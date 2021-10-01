<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
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
                'status' => $request->has('status') ? $request->status : 'all status',
                'role' => $request->has('role') ? $request->role : 'all roles',
            ],
        ]);
    }

    public function index(Request $request)
    {
        $this->authorize('show_user');

        $model_query = User::query()->with('roles')->canSee()->orderByDesc('id')->filter();

        return inertiaPro('Users/Index', [
            'users' => function () use ($model_query) {
                return UserResource::collection($model_query->paginate(10)->withQueryString());
            },
            'roles' => auth()->user()->roles->first()->canSee,
        ], '/users');
    }

    // edit users
    public function edit(User $user, Request $request)
    {
        $this->authorize('edit_user');

        $roles = Role::orderBy('id', "desc")->get();
        return inertiaPro('Users/Edit', [
            'oldUser' => function () use ($user) {
                return collect(new UserResource($user));
            },
            'roles' => function () use ($roles) {
                return $roles;
            },
        ]);
    }
    public function update(User $user, Request $request, UpdatesUserProfileInformation $updater)
    {

        $updater->update($user, $request->all());

        banner('success', 'profile information updated');

        return back();
    }

    // create new user
    public function create()
    {
        $this->authorize('create_user');
        $roles = auth()->user()->roles->first()->canSee;
        return inertiaPro('Users/Create', [
            'roles' => $roles,
        ]);
    }
    public function store(CreateNewUser $creator, Request $request)
    {
        $this->authorize('create_user');
        $user = $creator->create(request()->all());

        banner('info', 'user created successfuly');

        return redirect()->route('users.index');
    }

    public function destroyPhoto(User $user, Request $request)
    {
        $this->authorize('edit_user');
        $user->deleteProfilePhoto();

        banner('info', 'profile photo deleted');

        return back();
    }

    // delete one or many users
    public function destroy(User $user, Request $request)
    {
        $this->authorize('delete_user');
        $data = $request->validate([
            'password' => ['required', 'string', new Password],
        ]);
        if (!Hash::check($data['password'], auth()->user()->password)) {
            throw ValidationException::withMessages([
                'password' => ['The provided credentials are incorrect.'],
            ]);
        } else {
            $user->delete();
            banner('success', 'User Deleted Successfuly');
        }
        return back();
    }
    public function deleteAll(Request $request)
    {
        $this->authorize('delete_user');
        $data = $request->validate([
            'password' => ['required', 'string', new Password],
            'users' => ['required', 'array'],
        ]);
        if (!Hash::check($data['password'], auth()->user()->password) || in_array(auth()->id(), $data['users'])) {
            $msg = 'The provided Password are incorrect.';

            if (in_array(auth()->id(), $data['users'])) {
                $msg = 'You can\'t delete your acount from her';

                $request->session()->flash('flash.banner', 'You can\'t delete your acount from her');
                $request->session()->flash('flash.bannerStyle', 'error');
            }

            throw ValidationException::withMessages([
                'password' => [$msg],
            ]);
        } else {
            User::whereIn('id', $data['users'])->each(function ($user) {
                $user->delete();
            });
            banner('info', 'Selection Deleted Successfuly');
        }
        return back();
    }

    // toggle users status  active or not active
    public function changeStatus(User $user, Request $request)
    {
        $this->authorize('edit_user_status');

        $user->update([
            'is_active' => !$user->is_active,
        ]);

        $msg = $user->is_active ? 'Active' : 'Not Active';

        banner($user->is_active ? 'success' : 'notification', $user->name . ' is ' . $msg . ' Now');

        return inertiaPro('Users/Index', [
            'newUser' => (new UserResource($user))->toArray($request),
        ], '/users');
    }
    // toggle all users status  active or not active
    public function changeAllUsersStatus(Request $request)
    {
        $this->authorize('edit_user_status');

        $data = $request->validate([
            'users' => ['required', 'array'],
        ]);

        $users = User::whereIn('id', $data['users'])->get();

        $users->each(function ($user) {
            $user->is_active = !$user->is_active;
            $user->save();
        });

        return back(303);
    }
}
