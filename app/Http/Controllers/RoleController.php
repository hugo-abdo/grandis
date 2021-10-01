<?php

namespace App\Http\Controllers;

use App\Models\Role as ModelsRole;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('show_role');
        $model_query = Role::query()->with('permissions');

        return Inertia::render('Roles/Index', [
            'roles' => function () use ($model_query) {
                return $model_query->get(['id', 'name', 'color']);
            },
        ], '/roles');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create_role');
        return Inertia::render('Roles/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create_role');
        $data = $request->validate([
            'name' => ['required', 'string', 'unique:roles'],
            'color' => ['required', 'string'],
            'photo' => Rule::when($request->hasFile('photo'), ['image', 'mimes:png', 'max:1000']),
        ]);
        $data['name'] = str_replace(" ", '-', $data['name']);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photo->move('storage/roles/', $data['name'] . '.' . $photo->getClientOriginalExtension());
        }
        Role::create([
            'name' => $data['name'],
            'color' => $data['color'],
        ]);

        banner("success", 'role created successfuly');

        return redirect()->route('roles.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ModelsRole $role)
    {
        $this->authorize('edit_role');
        $permissions = Permission::all();
        $roles = Role::all();

        $role->permissions = $role->permissions;
        $role->can_see = $role->canSee;

        return Inertia::render('Roles/Edit', [
            'role' => $role,
            "permissions" => $permissions,
            "roles" => $roles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ModelsRole $role)
    {
        $this->authorize('edit_role');
        $data = $request->validate([
            'name' => ['required', 'string', Rule::unique('roles')->ignore($role->id)],
            'color' => ['required', 'string'],
            'permissions' => ['array'],
            'roles' => ['array'],
            'photo' => Rule::when($request->hasFile('photo'), ['image', 'mimes:png', 'max:1000']),
        ]);
        $data['name'] = str_replace(" ", '-', $data['name']);

        if ($request->hasFile('photo')) {
            Storage::disk('storage/roles/')->delete($role->name . '.png');
            $photo = $request->file('photo');
            $photo->move('storage/roles/', $data['name'] . '.' . $photo->getClientOriginalExtension());
        }

        $role->syncPermissions($data['permissions']);

        $role->canSee()->sync($data['roles']);

        $role->update([
            'name' => $data['name'],
            'color' => $data['color'],
        ]);
        banner('success', 'role updated');

        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role, Request $request)
    {
        $this->authorize('delete_role');
        if ($role->name == 'admin') {
            banner('warning', 'you can\'t delete the admin');
            return back(303);
        }
        $role->delete();
        banner('info', 'role deleted successfuly');
        return back(303);
    }

    /**
     * Get the disk that profile photos should be stored on.
     *
     * @return string
     */
    protected function PhotoDisk()
    {
        return isset($_ENV['VAPOR_ARTIFACT_NAME']) ? 's3' : config('jetstream.profile_photo_disk', 'public');
    }
}
