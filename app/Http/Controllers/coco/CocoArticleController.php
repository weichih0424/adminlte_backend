<?php

namespace App\Http\Controllers\coco;

use App\Http\Controllers\Controller;
use App\Models\CocoArticleModel;
use Illuminate\Http\Request;
use App\Http\Requests\CocoArticleVaildate;
use App\Services\AdminRolesService;
use App\Services\ImageSaveService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class CocoArticleController extends Controller
{
    private $role_name = 'coco_article';
    private $admin_roles;
    private $save_image;
    private $table = 'coco_article';
    private $save_path = 'coco/uploads/CocoArticle';

    public $field = [
        [
            'title' => '文章名稱',
            'type' => 'text',
            'name' => 'name',
            'placeholder' => '請輸入文章名稱',
            'required' => TRUE
        ],
        [
            'title' => '文章內容',
            'type' => 'textarea',   ##summernote
            'name' => 'intro',
            'id' => 'intro',
            'placeholder' => '請輸入文章內容',
            'required' => TRUE
        ],
        [
            'title' => '網址',
            'type' => 'text',
            'name' => 'url',
            'placeholder' => '請輸入文章網址',
            'required' => TRUE
        ],
        [
            'title' => '圖片',
            'type' => 'fileupload',
            'name' => 'image',
            'set' => [
                'data-min-file-count' => '1',
                'folder' => 'coco_article',
                'verify' => 'size:850,479'
            ],
            'hint' => '850x479',
            'required' => TRUE
        ],
        [
            'title' => 'FB連結',
            'type' => 'text',
            'name' => 'fb_url',
            'placeholder' => '請輸入FB網址',
        ],
        [
            'title' => 'YT連結',
            'type' => 'text',
            'name' => 'yt_url',
            'placeholder' => '請輸入YT網址',
        ],
        [
            'title' => 'LINE連結',
            'type' => 'text',
            'name' => 'line_url',
            'placeholder' => '請輸入LINE網址',
        ],
        [
            'title' => 'IG連結',
            'type' => 'text',
            'name' => 'ig_url',
            'placeholder' => '請輸入IG網址',
        ],
        [
            'title' => '狀態',
            'type' => 'select',
            'name' => 'status',
            'option' => [
                0 => '下架',
                1 => '上架'
            ],
        ],
    ];

    function __construct(AdminRolesService $admin_roles, ImageSaveService $save_image)
    {
        $this->admin_roles = $admin_roles;
        $this->save_image = $save_image;

        $this->middleware = $this->admin_roles->AdminRoles($this->role_name)->middleware;
        $this->function_role = $this->admin_roles->AdminRoles($this->role_name)->function_role;
        $this->menu_list = $this->admin_roles->AdminRoles($this->role_name)->menu_list;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_limit = 20;
        $header = '文章設定';
        $field = array('文章名稱','文章內容','圖片','狀態');
        $datas = CocoArticleModel::orderByRaw('ISNULL(`sort`),`sort` ASC')->orderBy('id','DESC')->paginate($page_limit);
        return view('coco.coco_article.index', compact('header', 'datas', 'field'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $header = '新增文章';
        $method = 'POST';
        $route = 'coco_article.store';
        $field = $this->field;
        $root = $this->role_name;

        return view('coco.coco_article.create', compact('header','field','root','route','method'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    public function store(CocoArticleVaildate $request)
    {
        $image_path = $this->save_image->save_to_s3_for_fileUpload($this->table,$this->save_path,$request->image);
        // dd($image_path);
        $data = $request->all();
        $data['image'] = $image_path;
        if($request->status == 1){
            $data['sort'] = 0;
        }
        // dd($data);
        CocoArticleModel::create($data);

        return redirect()->route('coco_article.index')->with('success', '資料儲存成功');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $header = '修改文章';
        $method = 'PATCH';
        $route = ['coco_article.update',$id];
        $field = $this->field;
        $root = $this->role_name;
        $data = CocoArticleModel::find($id);
        $data->start_at = date("Y-m-d\TH:i:s", strtotime($data->start_at));
        $data->end_at = date("Y-m-d\TH:i:s", strtotime($data->end_at));

        return view('coco.coco_article.create', compact('header', 'method', 'route', 'field', 'root', 'data', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    public function update(CocoArticleVaildate $request, $id)
    {
        $image_path = $this->save_image->save_to_s3_for_fileUpload($this->table,$this->save_path,$request->image,$id);
        $CocoArticleModel = CocoArticleModel::find($id);
        $data = $request->all();
        $data['image'] = $image_path;
        // dd($data['image']);
        if($request->status == 1){
            if($CocoArticleModel->sort == NULL){
                $data['sort'] = 0;
            }
        }else{
            $data['sort'] = 0;
        }
        $CocoArticleModel->update($data);

        return redirect()->route('coco_article.index')->with('success', '資料儲存成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //刪除storage/app/coco/uploads/CocoArticle底下的圖片
        $col='image';
        $data_image = DB::table($this->table)->find($id)->$col;
        Storage::disk('local')->delete(str_replace('http://127.0.0.1:8000/', '', $data_image));
        //刪除該文章
        CocoArticleModel::destroy($id);
        return redirect()->route('coco_article.index')->with('success', '資料刪除成功');
    }
}
