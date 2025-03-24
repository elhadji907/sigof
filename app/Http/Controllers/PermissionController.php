<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{

    public function __construct()
    {
        $this->middleware("auth");
        $this->middleware(['role:super-admin|admin']);
        $this->middleware("permission:permission-view", ["only" => ["index"]]);
        $this->middleware("permission:permission-create", ["only" => ["create", "store"]]);
        $this->middleware("permission:permission-update", ["only" => ["update", "edit"]]);
        $this->middleware("permission:permission-show", ["only" => ["show"]]);
        $this->middleware("permission:permission-delete", ["only" => ["destroy"]]);
        $this->middleware("permission:give-role-permissions", ["only" => ["givePermissionsToRole"]]);
    }

    public function index()
    {
        $permissions = Permission::orderBy('created_at', 'desc')->get();
        return view("role-permission.permission.index", compact('permissions'));
    }

    public function create()
    {
        return view("role-permission.permission.create");
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            /* 'permissions.*.name' => 'required|unique:permissions,name', */
            'permissions.0.name' => 'required|unique:permissions,name',
        ]);

        /* dd($request->permissions); */

        foreach ($request->permissions as $key => $value) {
            Permission::create($value);
        }

        /* Permission::create([
            "name" => $request->name
        ]); */
        Alert::success('Succès ', 'Permission créée avec succès');

        return redirect()->back();
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view("role-permission.permission.update", compact('permission'));
    }

    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);
        $this->authorize('update', $permission);
        $this->validate($request, [
            'name' => ['required', 'string', Rule::unique(Permission::class)->ignore($id)],
        ]);

        Permission::findOrFail($id)->update([
            'name' => $request->name,
        ]);

        $permissions = Permission::get();
        Alert::success('Succès ', 'Permission modifiée avec succès');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $this->authorize('delete', $permission);
        $permission->delete();
        Alert::success('Succès ', 'Permission ' . $permission->name . ' supprimée avec succès');
        return redirect()->back();
    }
}
