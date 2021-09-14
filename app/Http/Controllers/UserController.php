<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Laravel\Fortify\Rules\Password;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $this->authorize('show_user');

        $model_query = User::query()->with('roles')->orderByDesc('id')->filter();

        return inertiaPro('Users/Index', [
            'users' => function () use ($model_query) {
                return UserResource::collection($model_query->paginate(10)->withQueryString());
            },
            'roles' => Role::all(),
            'filter' => [
                'status' => $request->has('status') ? $request->status : 'all status',
                'role' => $request->has('role') ? $request->role : 'all roles',
            ],
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

        $request->session()->flash('flash.banner', 'profile information updated');
        $request->session()->flash('flash.bannerStyle', 'success');

        return back();
    }

    // create new user
    public function create()
    {
        $this->authorize('create_user');
        $roles = Role::orderBy('id', "desc")->get();
        return inertiaPro('Users/Create', [
            'roles' => $roles,
        ]);
    }
    public function store(CreateNewUser $creator, Request $request)
    {
        $this->authorize('create_user');
        $user = $creator->create(request()->all());

        $request->session()->flash('flash.banner', 'User Created Successfuly');
        $request->session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('users.index');
    }

    public function destroyPhoto(User $user, Request $request)
    {
        $this->authorize('edit_user');
        $user->deleteProfilePhoto();

        $request->session()->flash('flash.banner', 'profile photo deleted');
        $request->session()->flash('flash.bannerStyle', 'success');

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
            $request->session()->flash('flash.banner', 'User Deleted Successfuly');
            $request->session()->flash('flash.bannerStyle', 'success');
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
                $request->session()->flash('flash.bannerStyle', 'danger');
            }

            throw ValidationException::withMessages([
                'password' => [$msg],
            ]);
        } else {
            User::whereIn('id', $data['users'])->each(function ($user) {
                $user->delete();
            });
            $request->session()->flash('flash.banner', 'Selection Deleted Successfuly');
            $request->session()->flash('flash.bannerStyle', 'success');
        }
        return back();
    }

    // toggle users status  active or not active
    public function changeStatus(User $user, Request $request)
    {
        $this->authorize('edit_user_status');

        $user->is_active = !$user->is_active;
        $user->save();
        $msg = $user->is_active ? 'Active' : 'Not Active';
        $request->session()->flash('flash.banner', $user->name . ' is ' . $msg . ' Now');
        $request->session()->flash('flash.bannerStyle', $user->is_active ? 'success' : 'danger');

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

        return inertiaPro('Users/Index', [], '/users');
    }
}
