<?php

namespace App\Http\Controllers\Admin\Masters;

use App\Constants\AiText;
use App\Http\Controllers\Controller;
use App\Models\KisiKisi;
use App\Models\Meeting;
use App\Models\MeetingSubcpmk;
use App\Models\Rps;
use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MeetingController extends Controller
{
    protected $meeting, $meetingSubCpmk, $kisi, $type, $user, $rps;

    public function __construct(Meeting $meeting, Type $type, User $user, Rps $rps, MeetingSubcpmk $meetingSubCpmk, KisiKisi $kisi)
    {
        $this->meeting = $meeting;
        $this->meetingSubCpmk = $meetingSubCpmk;
        $this->kisi = $kisi;
        $this->user = $user;
        $this->type = $type;
        $this->rps = $rps;
    }

    public function generateKisi($id)
    {
        $data = $this->meeting->with(['subCpmk'])->find($id);
        if (!$data)
            return $this->notFound();

        $subCpmk = "";

        foreach ($data->subCpmk as $key => $value) {
            $subCpmk .= $value->subcpmk . " dengan limit KKO Taksonomi Bloom " . $value->limit_bloom . " , ";
        }

        // Ambil respons AI
        $text = $this->generateAI(AiText::GenerateKisi($data->title, $data->desc, $subCpmk));

        Log::info('AI Response: ' . $text);

        $text = preg_replace('/```(?:json)?|```/i', '', $text);
        $text = trim($text);

        $json = json_decode($text);

        if (is_array($json)) {
            foreach ($json as $key => $value) {
                $taksonomi = $value->taksonomi_bloom;

                // Gabungkan kedua field jika ada
                $items = [];

                if (isset($value->isi)) {
                    $items = array_merge($items, $value->isi);
                }

                if (isset($value->{'kisi-kisi'})) {
                    $items = array_merge($items, $value->{'kisi-kisi'});
                }

                foreach ($items as $val) {
                    $this->kisi->create([
                        "taksonomi_bloom" => $taksonomi,
                        "type" => $val->type,
                        "kisi_kisi" => $val->question,
                        "meeting_id" => $id,
                    ]);
                }
            }
        } else {
            Log::error('Data tidak valid atau bukan array:', ['response' => $text]);
        }

        return $this->success('Success Show Meeting', $json);
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
            'title' => 'required|string|max:255',
            'desc' => 'required|string',
            'minggu_ke' => 'required|integer',
            'rps_id' => 'required|exists:rps,id',
            'subcpmks' => 'required|array',
            'subcpmks.*' => 'exists:sub_cpmks,id',
        ]);

        if ($validator->fails()) {
            return $this->failed($validator->errors()->first());
        }
        // End Validator

        // Simpan data Meeting
        $create = collect($request->only($this->meeting->getFillable()))
            ->filter()
            ->toArray();

        $meeting = $this->meeting->create($create);

        // Simpan relasi Meeting - SubCPMK
        foreach ($request->subcpmks as $subcpmk_id) {
            $this->meetingSubCpmk->create([
                'meeting_id' => $meeting->id,
                'subcpmk_id' => $subcpmk_id,
            ]);
        }

        return $this->success('Success Create New Meeting', $meeting);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = $this->meeting->with(['subCpmk', 'kisi'])->find($id);
        if (!$data)
            return $this->notFound();
        return $this->success('Success Show Meeting', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Meeting $meeting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $data = $this->meeting->find($id);
        if (!$data)
            return $this->notFound();

        $update = collect($request->only($this->meeting->getFillable()))
            ->filter();

        $data->update($update->toArray());

        if ($request->subcpmks) {
            $this->meetingSubCpmk->where('meeting_id', $id)->delete();
            foreach ($request->subcpmks as $subcpmk_id) {
                $this->meetingSubCpmk->create([
                    'meeting_id' => $id,
                    'subcpmk_id' => $subcpmk_id,
                ]);
            }
        }

        $this->successToast('Success Update Sub CPMK');

        return $this->success('Success Update Sub CPMK', $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = $this->meeting->find($id);
        if (!$data)
            return $this->notFound();

        $data->delete();
        return $this->success('Success Hapus Meeting', $data);
    }
}
