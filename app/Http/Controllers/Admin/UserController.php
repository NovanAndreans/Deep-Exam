<?php

namespace App\Http\Controllers\Admin;

use App\Constants\DBTypes;
use App\Constants\FileDirectory;
use App\Constants\Routes;
use App\Constants\Systems;
use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Menu;
use App\Models\Type;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    protected $user, $type, $menu, $file;

    public function __construct(UserService $user, Type $type, Menu $menu, File $file)
    {
        $this->user = $user;
        $this->type = $type;
        $this->menu = $menu;
        $this->file = $file;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->user->with(['roles'])->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('roles', function ($row) {
                    return $row->roles->name;
                })
                ->addColumn('action', function ($row) {
                    if ($row->id == 1) {
                        $btn = '';
                    } else {
                        $btn = '
                            <button onclick="editForm(`' . route('users.update', $row->id) . '`)" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit ' . $row->name . '">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button onclick="deleteData(`' . route('users.destroy', $row->id) . '`)" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete ' . $row->name . '">
                                <i class="fa fa-trash"></i>
                            </button>
                        ';
                    }

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $features = $this->setFeatureSession(Routes::routeMasterUsers);

        $genders = $this->type->where('master_id', $this->type->getIdByCode(DBTypes::UserGender))->get();
        $roles = $this->type->where('master_id', $this->type->getIdByCode(DBTypes::UserRole))->whereNotIn('id', [
            $this->type->getIdByCode(DBTypes::RoleSuperAdmin)
        ])->get();
        return view('AdminPages.Masters.Users.index', compact('roles', 'genders', 'features'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validator
        $validator = Validator::make($request->all(), [
            'role_id' => 'required',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails())
            return $this->failed($validator->errors()->first());
        // End Validator

        $create = collect($request->only($this->user->getFillable()))
            ->filter()
            ->put('password', Hash::make($request->password))
            ->put('created_by', Auth::user()->id)
            ->toArray();


        $data = $this->user->create($create);

        if ($request->hasFile('photo')) {
            $type = $this->type->getIdByCode(DBTypes::FileProfilePic);

            $this->uploadFile($request->file('photo'), $type, $data->id, $request->file('photo')->hashName(), FileDirectory::PhotoProfiles);
        }

        return $this->success('Success Create New User', $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->user->getQuery()->find($id);
        if (!$data)
            return $this->notFound();
        return $this->success('Success Show User', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $this->user->find($id);
        if (!$data)
            return $this->notFound();

        // Validator
        $validator = Validator::make($request->all(), [
            'email' => 'email',
        ]);

        if ($validator->fails())
            return $validator->errors();
        // End Validator

        $update = collect($request->only($this->user->getFillable()))
            ->filter()
            ->put('updated_by', Auth::user()->id);

        if ($request->has('password') && $request->password != '') {
            if ($request->password != $request->password_confirmation)
                return $this->failed('Invalid confirmation password', null, 403);
            $update
                ->put('password', Hash::make($request->password));
        }

        $data->update($update->toArray());

        if ($request->hasFile('photo')) {
            $type = $this->type->getIdByCode(DBTypes::FileProfilePic);

            $this->uploadFile($request->file('photo'), $type, $data->id, $request->file('photo')->hashName(), FileDirectory::PhotoProfiles, $data->created_by);
        }

        return $this->success('Success Update User', $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = $this->user->find($id);
        if (!$data)
            return $this->notFound();

        $thumbnail = $this->file->where('transtypeid', $this->type->getIdByCode(DBTypes::FileProfilePic))->where('refid', $id)->first();
        if ($thumbnail) {
            $this->deleteFile($thumbnail->directories, $thumbnail->filename);
            $thumbnail->delete();
        }

        $data->delete();
        return $this->success('Success Update pengguna', $data);
    }
}
