<?php

namespace App\Http\Controllers\Admin\Masters;

use App\Constants\Routes;
use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Rps;
use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class RpsController extends Controller
{
    protected $rps, $type, $user, $file;

    public function __construct(Rps $rps, Type $type, User $user, File $file)
    {
        $this->rps = $rps;
        $this->user = $user;
        $this->type = $type;
        $this->file = $file;
    }

    public function subCpmkView($id)
    {
        $id = decrypt($id);
        $data = $this->rps->with(['subCpmk', 'meeting' => function ($query) {
            $query->with(['kisi']);
        }])->find($id);
        $features = $this->setFeatureSession(Routes::routeMasterRps);
        return view('AdminPages.Masters.Rps.subCpmk', compact('data', 'features'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->rps->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '
                        <button onclick="window.location.href=`' . route('rps.subCpmk', encrypt($row->id)) . '`" class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Sub CPMK of ' . $row->title . '">
                            <i class="fa fa-list"></i>
                        </button>
                        <button onclick="editForm(`' . route('rps.update', $row->id) . '`)" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit ' . $row->title . '">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button onclick="deleteData(`' . route('rps.destroy', $row->id) . '`)" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete ' . $row->title . '">
                            <i class="fa fa-trash"></i>
                        </button>
                    ';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $features = $this->setFeatureSession(Routes::routeMasterRps);
        return view('AdminPages.Masters.Rps.index', compact('features'));
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
            'title' => 'required|string|max:255',
            'desc' => 'required',
            'cpmk' => 'required',
        ]);

        if ($validator->fails())
            return $this->failed($validator->errors()->first());
        // End Validator

        $create = collect($request->only($this->rps->getFillable()))
            ->filter()
            ->put('created_by', Auth::user()->id)
            ->toArray();

        $data = $this->rps->create($create);

        return $this->success('Success Create New RPS', $data);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = $this->rps->getQuery()->find($id);
        if (!$data)
            return $this->notFound();
        return $this->success('Success Show User', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rps $rps)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $data = $this->rps->find($id);
        if (!$data)
            return $this->notFound();

        $update = collect($request->only($this->rps->getFillable()))
            ->filter()
            ->put('updated_by', Auth::user()->id);

        $data->update($update->toArray());

        return $this->success('Success Update RPS', $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = $this->rps->find($id);
        if (!$data)
            return $this->notFound();

        $data->delete();
        return $this->success('Success Hapus RPS', $data);
    }
}
