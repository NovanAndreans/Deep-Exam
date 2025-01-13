<?php

namespace App\Http\Controllers\Admin;

use App\Constants\DBTypes;
use App\Constants\FileDirectory;
use App\Constants\Routes;
use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Menu;
use App\Models\Type;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\HtmlString;
use Yajra\DataTables\Facades\DataTables;

class TypeController extends Controller
{
    protected $user, $type, $menu, $file;

    public function __construct(User $user, Type $type, Menu $menu, File $file)
    {
        $this->user = $user;
        $this->type = $type;
        $this->menu = $menu;
        $this->file = $file;
    }

    public function select(Request $request)
    {
        $id = $request->id;
        $data = $this->type->where('master_id', $id)->get();

        return $this->success('Success', $data);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->type->where('master_id', null)->with(['children' => function ($query) {
                return $query->with('children');
            }])->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('children', function ($row) {
                    // Fungsi rekursif untuk memproses children
                    $renderChildren = function ($items, $isChild = false) use (&$renderChildren) {
                        $list = $isChild ? '<ul>' : '<ol>'; // Gunakan <ul> jika children, <ol> jika parent
                        foreach ($items as $item) {
                            $list .= '<li>
                    <div class="d-flex justify-content-between w-100">
                        <p>' . $item->name . '</p>';

                            // Tampilkan tombol hanya jika desc === null
                            if ($item->desc === null) {
                                $list .= '<div>
                        <button class="btn btn-warning btn-sm" onclick="editForm(`' . route('types.update', $item->id) . '`)" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit ' . $item->name . '"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-danger btn-sm" onclick="deleteData(`' . route('types.destroy', $item->id) . '`)" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete ' . $item->name . '"><i class="fa fa-trash"></i></button>
                    </div>';
                            }

                            $list .= '</div>';

                            // Jika memiliki children, panggil fungsi ini secara rekursif
                            if (!empty($item->children)) {
                                $list .= $renderChildren($item->children, true); // Children menggunakan <ul>
                            }

                            $list .= '</li>';
                        }
                        $list .= $isChild ? '</ul>' : '</ol>';
                        return $list;
                    };

                    // Mulai render dari row utama
                    return new HtmlString($renderChildren($row->children));
                })
                ->rawColumns(['children'])
                ->make(true);
        }

        $features = $this->setFeatureSession(Routes::routeSettingTypes);
        $parent = $this->type->where('master_id', null)->get();

        return view('AdminPages.Settings.Types.index', compact('features', 'parent'));
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
            'name' => 'required'
        ]);

        if ($validator->fails())
            return $this->failed($validator->errors()->first());
        // End Validator

        $create = collect($request->only($this->type->getFillable()))
            ->filter()
            ->toArray();

        $data = $this->type->create($create);

        if ($request->hasFile('picture')) {
            $type = $this->type->getIdByCode(DBTypes::FileTypePic);

            $this->uploadFile($request->file('picture'), $type, $data->id, $request->file('picture')->hashName(), FileDirectory::TypeFiles);
        }
        return $this->success('Success Create New Type', $data);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = $this->type->with(['parent'])->find($id);
        if (!$data)
            return $this->notFound();
        return $this->success('Success Show Type', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Type $type)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $data = $this->type->find($id);
        if (!$data)
            return $this->notFound();

        $update = collect($request->only($this->type->getFillable()))
            ->filter();

        $data->update($update->toArray());

        if ($request->hasFile('picture')) {
            $type = $this->type->getIdByCode(DBTypes::FileTypePic);

            $this->uploadFile($request->file('picture'), $type, $data->id, $request->file('picture')->hashName(), FileDirectory::TypeFiles, $data->created_by);
        }

        return $this->success('Success Update Type', $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = $this->type->find($id);
        if (!$data)
            return $this->notFound();

        $thumbnail = $this->file->where('transtypeid', $this->type->getIdByCode(DBTypes::FileTypePic))->where('refid', $id)->first();
        if ($thumbnail) {
            $this->deleteFile($thumbnail->directories, $thumbnail->filename);
            $thumbnail->delete();
        }
        $data->delete();
        return $this->success('Berhasil menghapus Type', $data);
    }
}
