<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Jetstream\DeleteUser;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Laravel\Fortify\Rules\Password;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct(Request $request)
    {
        Inertia::share([
            'filter' => [
                'status' => fn() => $request->has('status') ? $request->status : 'all status',
                'role' => fn() => $request->has('role') ? $request->role : 'all roles',
            ],
            'roles' => fn() => auth()->user()->roles->first()->canSee,
        ]);
    }

    public function index(Request $request)
    {
        $model_query = User::query()->with('roles')->canSee()->orderByDesc('id')->filter();
        return inertiaPro('Users/Index', [
            'users' => fn() => UserResource::collection($model_query->paginate(10)->withQueryString()),
        ], '/users');
    }

    // edit users
    public function edit(User $user, Request $request)
    {
        $roles = Role::orderBy('id', "desc")->get();
        return inertiaPro('Users/Edit', [
            'oldUser' => fn() => collect(new UserResource($user)),
        ]);
    }
    public function update(User $user, Request $request, UpdatesUserProfileInformation $updater)
    {
        $updater->update($user, $request->all());
        banner('success', 'profile information updated successfuly');
        return back();
    }
    public function destroyPhoto(User $user, Request $request)
    {
        $user->deleteProfilePhoto();
        banner('info', 'profile photo deleted');
        return back();
    }

    // create new user
    public function create()
    {
        return inertiaPro('Users/Create');
    }
    public function store(CreateNewUser $creator, Request $request)
    {
        $user = $creator->create(request()->all());
        banner('info', 'user created successfuly');
        return redirect()->route('users.index');
    }

    // delete one or many users
    public function destroy(User $user, Request $request, DeleteUser $deleteUserService)
    {
        $data = $request->validate([
            'password' => ['required', 'string', new Password],
        ]);
        if (!Hash::check($data['password'], auth()->user()->password)) {
            banner('error', 'The provided credentials are incorrect.');
            throw ValidationException::withMessages([
                'password' => ['The provided credentials are incorrect.'],
            ]);
        } else {
            $deleteUserService->delete($user);
            banner('success', 'User Deleted Successfuly');
        }
        return back();
    }
    public function deleteAll(Request $request, DeleteUser $deleteUserService)
    {
        $data = $request->validate([
            'password' => ['required', 'string', new Password],
            'users' => ['required', 'array'],
        ]);
        if (!Hash::check($data['password'], auth()->user()->password) || in_array(auth()->id(), $data['users'])) {
            $msg = 'The provided Password are incorrect.';

            if (in_array(auth()->id(), $data['users'])) {
                $msg = 'You can\'t delete your acount from her';
            }

            banner('error', $msg);
            throw ValidationException::withMessages([
                'password' => [$msg],
            ]);
        } else {
            User::whereIn('id', $data['users'])->each(fn($user) => $deleteUserService->delete($user));
            banner('info', 'Selection Deleted Successfuly');
        }
        return back();
    }

    // toggle users status  active or not active
    public function changeStatus(User $user, Request $request)
    {
        $user->update(['is_active' => !$user->is_active]);
        $msg = $user->is_active ? 'Active' : 'Not Active';
        banner('info', $user->name . ' is ' . $msg . ' Now');
        return inertiaPro('Users/Index', [
            'newUser' => (new UserResource($user))->toArray($request),
        ], '/users');
    }
    // toggle all users status  active or not active
    public function changeAllUsersStatus(Request $request)
    {
        $data = $request->validate(['users' => ['required', 'array']]);
        $users = User::whereIn('id', $data['users'])->get();
        $users->each(fn($user) => $user->update(['is_active' => true]));
        banner('info', 'selection activated successfuly');
        return back(303);
    }
}
