<?php

namespace App\Http\Controllers;

use App\Constants\Systems;
use App\Models\File;
use App\Models\Menu;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

abstract class Controller
{
    use AuthorizesRequests, ValidatesRequests;

    public function successToast($message = 'Success')
    {
        Session::flash(Systems::sessionSuccess, $message);
    }

    public function failedToast($message = 'Failed')
    {
        Session::flash(Systems::sessionError, $message);
    }

    public function success($message = 'Success', $data = null, $code = 200)
    {
        if ($data == null)
            return response()->json(['message' => $message], $code);
        else
            return response()->json(['message' => $message, 'data' => $data], $code);
    }

    public function failed($message = 'Failed', $data = null, $code = 400)
    {
        if ($data == null)
            return response()->json(['message' => $message], $code);
        else
            return response()->json(['message' => $message, 'data' => $data], $code);
    }

    public function notFound($message = 'Data Not Found!')
    {
        return response()->json(['message' => $message], 404);
    }

    public function setMenuSession()
    {
        $menu = new Menu();
        $menus = $menu->where('masterid', null)->with([
            'features' => function ($query) {
                $query->where('featslug', 'view')->whereHas('permissions', function ($query) {
                    $query->where('role', Auth::user()->role_id);
                });
            },
            'children' =>
            function ($query) {
                $query->with(['features' => function ($query) {
                    $query->where('featslug', 'view')->whereHas(
                        'permissions',
                        function ($query) {
                            $query->where('role', Auth::user()->role_id);
                        }
                    );
                }]);
            },
        ])->get();

        session()->put(Systems::sessionMenus, $menus);
    }

    public function setFeatureSession(string $route)
    {
        $menu = new Menu();
        return $menu->where('menuroute', $route)
            ->with(['features' => function ($query) {
                $query->whereNot('featslug', 'view')->with(['permissions'])->whereHas('permissions', function ($query) {
                    $query->where('role', Auth::user()->role_id);
                });
            }])->first();
    }

    public function uploadFile($file, $type, $refid, $filename, $directory, $creatorid = null)
    {
        $filesService = new File();
        if ($creatorid) {

            $oldFile = $filesService->where('refid', $refid)->where('transtypeid', $type)->first();
            if ($oldFile) {
                unlink(public_path("$directory/" . $oldFile->filename));
                $oldFile->delete();
            }

            $result = $file->storeAs($directory, $filename, 'root_public');
            if ($result) {
                $data = [];

                $data['transtypeid'] = $type;
                $data['refid'] = $refid;
                $data['directories'] = $directory;
                $data['filename'] = $filename;
                $data['mimetype'] = $file->getMimeType();
                $data['filesize'] = $file->getSize();
                $data['created_by'] = $creatorid;
                $data['updated_by'] = auth()->user()->id;
                $filesService->create($data);
            }
        } else {
            // $result = $file->move(public_path($directory), $filename);
            $result = $file->storeAs($directory, $filename, 'root_public');
            if ($result) {
                $data = [];

                $data['transtypeid'] = $type;
                $data['refid'] = $refid;
                $data['directories'] = $directory;
                $data['filename'] = $filename;
                $data['mimetype'] = $file->getMimeType();
                $data['filesize'] = $file->getSize();
                $data['created_by'] = auth()->user()->id;
                $filesService->create($data);
            }
        }
    }
}
