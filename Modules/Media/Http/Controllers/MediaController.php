<?php

namespace Modules\Media\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
use Modules\Media\Entities\MediaModal as MainModel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    private $pathViewController     = "media::pages.admin.";
    private $controllerName         = "media_admin";
    private $moduleName         = "media";
    private $model;
    private $params                 = [];
    function __construct()
    {
        $this->model = new MainModel();
        View::share('controllerName', $this->controllerName);
        View::share('moduleName', $this->moduleName);
    }
    public function index()
    {
        return view('media::index');
    }
    public function folders(Request $request)
    {
        $result = [
            [
                'id' => 1,
                'name' => 'paul',
                'note' => '',
            ],
            [
                'id' => 1,
                'name' => 'giang ga',
                'note' => '',
            ],
        ];
        return response()->json($result);
    }
    public function action(Request $request)
    {
        $result = [];
        $func = $request->func;
        if ($func == 'load_thumbs') {
            $items = $this->model->listItems([],['task' => 'list']);
            $items = $items ? $items->toArray() : [];
          
            $result = [
                'items' => $items,
                "total" => 10,
                "page" => 1,
                "ipp" => 10,
                "gtotal" => $this->model->count(),
                'items' => $items,
            ];
        } elseif ($func == 'mlib_get_import_methods') {
            $result = [
                [
                    'id' => 1,
                    'title' => 'Full URL for multiple lines',
                    'content' => '%%url%% [%%fullsize%%]<br />',
                    'contentx' => '%%url%% [%%fullsize%%]<br />',
                ],
            ];
        }
        elseif($func == 'mlib_delete_items') {
            $mlibid = $request->mlibid;
            $totalFile = count($mlibid);
            $result = "{$totalFile} Files were deleted from the seleted 1 files";
            if($totalFile > 0) {
                foreach ($mlibid as $id) {
                    $this->model->deleteItem(['id' => $id],['task' => 'delete']);
                }
            }
        }
        return response()->json(
            $result,
            200,
            [
                'Content-Type' => 'text/html',
                'Charset' => 'utf-8'
            ]
        );
        // return response()->json($result);
    }
    public function upload(Request $request)
    {
        #_Get all file
        $files = Storage::disk('obn_storage')->files('images');
        $params = $request->all();
        $image = $request->file('file');
        $extension = $image->clientExtension();
        $size = $image->getSize();
        $imageName = Str::random(10) . "." .$extension;
        $thumb  = url('public/uploads/images');
        $paramsInsert = [
            "type" => $extension,
            "title" => $imageName,
            "caption" => $imageName,
            "url" => "{$imageName}",
            "thumb" => "{$imageName}",
            "time" => time(),
            "size" => $size,
            "disk" => "public",
            "folder_id" => 0,
            "folder" => null,
            "newtime" => date('Y-m-d H:i:s'),
        ];
        $image->storeAs('images',$imageName,'obn_storage');
        $this->model->saveItem($paramsInsert,['task' => 'add-item']);
        $result = [
            'files' => $files,
            'params' => $params,
        ];
        return $result;
    }
}
