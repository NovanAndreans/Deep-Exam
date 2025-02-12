<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Constants\DBTypes;
use App\Constants\Routes;
use App\Constants\Systems;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Permission;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    protected $permission, $menu, $type;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Permission $permission, Menu $menu, Type $type)
    {
        $this->permission = $permission;
        $this->menu = $menu;
        $this->type = $type;
    }

    public function togglePermission(Request $request)
    {
        $request->validate([
            'role' => 'required|string',
            'feature' => 'required|integer',
            'is_checked' => 'required'
        ]);

        try {
            $roleId = $request->input('role');
            $featureId = $request->input('feature');
            $isChecked = $request->input('is_checked') == 'true' ? true : false;

            if ($isChecked) {
                // Add permission
                Permission::firstOrCreate([
                    'role' => $roleId,
                    'permisfeatid' => $featureId,
                ]);
                $status = 'Permission added.';
            } else {
                // Remove permission
                Permission::where('role', $roleId)
                    ->where('permisfeatid', $featureId)
                    ->delete();
                $status = 'Permission removed.';
            }

            $this->setMenuSession();

            return response()->json(['message' => $status, 'success' => true]);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return response()->json(['message' => 'Invalid role parameter.', 'success' => false], 400);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred.', 'success' => false], 500);
        }
    }

    public function deletePermission(Request $request)
    {
        $data = $this->permission->where('role', $request->role)->where('permisfeatid', $request->permisfeatid)->delete();
        return $this->success('Success Delete Permission', $data);
    }

    public function getPermission(Request $request)
    {
        $data = $this->permission->where('role', $request->role)->get();
        return $this->success('Success Show Permission', $data);
    }

    public function getMyPermission()
    {
        $data = $this->permission->where('role', Auth::user()->role)->with(['feature' => function ($query) {
            $query->with(['menu']);
        }])->get();
        return $this->success('Success Show Permission', $data);
    }

    public function index(Request $request)
    {
        $roles = $this->type->whereNot('code', DBTypes::RoleSuperAdmin)->where('master_id', $this->type->getIdByCode(DBTypes::UserRole))->get();
        $menus = $this->menu->with(['features'])->get();

        if ($request->role) {
            $data = $this->permission->where('role', Crypt::decryptString($request->role))->get();
            $roleActive = $this->type->where('id', Crypt::decryptString($request->role))->first()->name;
            $roleActiveId = $this->type->where('id', Crypt::decryptString($request->role))->first()->id;
        } else {
            $data = $this->permission->where('role', $this->type->where('master_id', $this->type->getIdByCode(DBTypes::UserRole))
                ->orderBy('id', 'desc')->first()->id)->get();
            $roleActive = $this->type->where('master_id', $this->type->getIdByCode(DBTypes::UserRole))->orderBy('id', 'desc')->first()->name;
            $roleActiveId = $this->type->where('master_id', $this->type->getIdByCode(DBTypes::UserRole))->orderBy('id', 'desc')->first()->id;
        }

        $features = $this->setFeatureSession(Routes::routeSettingPermission);

        return view('AdminPages.Settings.Permissions.index', compact('roles', 'roleActive', 'data', 'menus', 'roleActiveId', 'features'));
    }

    public function store(Request $request)
    {
        // Validator
        $validator = Validator::make($request->all(), [
            'permisfeatid' => 'required|int'
        ]);

        if ($validator->fails())
            return $this->failed($validator->errors()->first());
        // End 

        $create = collect($request->only($this->permission->getFillable()))
            ->filter()
            ->put('created_by', Auth::user()->id)
            ->toArray();

        $data = $this->permission->create($create);

        return $this->success('Success Create New Permission', $data);
    }

    public function show($id)
    {
        $data = $this->permission->find($id);
        if (!$data)
            return $this->notFound();
        return $this->success('Success Show Permission', $data);
    }

    public function update($id, Request $request)
    {
        $data = $this->permission->find($id);
        if (!$data)
            return $this->notFound();

        $update = collect($request->only($this->permission->getFillable()))
            ->filter()
            ->put('updated_by', $request->session()->get('id'));

        $data->update($update->toArray());
        return $this->success('Success Update Permission', $data);
    }

    public function destroy($id)
    {
        $data = $this->permission->find($id);
        if (!$data)
            return $this->notFound();
        $data->delete();
        return $this->success('Success Delete Permission', $data);
    }
}
