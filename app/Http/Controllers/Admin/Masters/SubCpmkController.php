<?php

namespace App\Http\Controllers\Admin\Masters;

use App\Constants\AiText;
use App\Http\Controllers\Controller;
use App\Models\SubCPMK;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubCpmkController extends Controller
{
    protected $subCpmk;
    public function __construct(SubCPMK $subCpmk)
    {
        $this->subCpmk = $subCpmk;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'subcpmk' => 'required',
            'cpmk_id' => 'required',
        ]);

        if ($validator->fails())
            return $this->failed($validator->errors()->first());
        // End Validator

        $limit = $this->generateAI(AiText::CheckSubCpmkLimit($request->subcpmk));

        $create = collect($request->only($this->subCpmk->getFillable()))
            ->put('limit_bloom', $limit)
            ->filter()
            ->toArray();

        $data = $this->subCpmk->create($create);

        $this->successToast('Success Create New Sub CPMK');

        return $this->success('Success Create New RPS', $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(SubCPMK $subCPMK)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubCPMK $subCPMK)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $data = $this->subCpmk->find($id);
        if (!$data)
            return $this->notFound();

        $limit = $this->generateAI(AiText::CheckSubCpmkLimit($request->subcpmk));
        
        $update = collect($request->only($this->subCpmk->getFillable()))
            ->put('limit_bloom', $limit)
            ->filter();

        $data->update($update->toArray());

        $this->successToast('Success Update Sub CPMK');

        return $this->success('Success Update Sub CPMK', $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = $this->subCpmk->find($id);
        if (!$data)
            return $this->notFound();

        $data->delete();

        $this->successToast('Success Delete Sub CPMK');
        return $this->success('Success Hapus Sub CPMK', $data);
    }
}
