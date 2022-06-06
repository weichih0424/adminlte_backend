<?php

namespace App\Http\Controllers\coco;

use App\Http\Controllers\Controller;
use App\Models\CocoArticleModel;
use App\Models\CocoCategoryModel;
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
        'select_category'=>[
            'title' => '分類名稱',
            'type' => 'select_category',
            'id' => 's',
            'name' => 'new_select_category',
            'option' => [
                // 0 => '下架',
                // 1 => '上架'
            ],
            // 'placeholder' => '請選擇分類',
            // 'required' => TRUE
        ],
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
        // [
        //     'title' => '網址',
        //     'type' => 'text',
        //     'name' => 'url',
        //     'placeholder' => '請輸入文章網址',
        //     'required' => TRUE
        // ],
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
    // 搜尋資料庫的coco_category資料表，加入下拉式選單
    public function select_category()
    {
        $CocoCategorys = CocoCategoryModel::orderByRaw('ISNULL(`sort`),`sort` ASC')->where('status','=',1)->get();
        foreach ($CocoCategorys as $key => $v) {
            $this->field['select_category']['option'][$key+1]=$v->name;
        }
    }
    // 文章分類數字轉換成字串
    // public function category_show()
    // {
    //     $page_limit = 20;
    //     $datas = CocoArticleModel::orderByRaw('ISNULL(`sort`),`sort` ASC')->orderBy('id','DESC')->paginate($page_limit);
    //     $coco_category_datas = CocoCategoryModel::orderByRaw('ISNULL(`sort`),`sort` ASC')->paginate($page_limit);
        
    //     $new_array = array();
    //     $new_array2 = array();
        
    //     foreach($datas as $key => $v){
    //         $new_array3 = array();
    //         $select_categorys = $v->select_category;
    //         $select_category = explode(",",$select_categorys);
    //         $v->select_category = $select_category;

    //         foreach($v->select_category as $kk => $vv){
    //             $new_array[$key] = $v;
    //             array_push($new_array2,$vv);
    //             $new_array[$key]->new_category = $new_array2;

    //             foreach($coco_category_datas as $key2 => $vvv){
    //                 if($v->select_category[$kk] == $vvv->id){
    //                     array_push($new_array3,$vvv->name);
    //                     $new_array[$key]->new_category = $new_array3;
    //                     $new_category = $new_array[$key]->new_category;
    //                 }
    //             }
    //             $implode_category = implode(" / ",$new_category); 
    //             $new_array[$key]->new_category = $implode_category;
    //         }
    //     }
    //     return $new_array;
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_limit = 5;
        $header = '文章設定';
        $field = array('文章名稱','文章內容','圖片','狀態');
        // $new_array = $this->category_show();
        $datas = CocoArticleModel::orderByRaw('ISNULL(`sort`),`sort` ASC')->orderBy('id','DESC')->paginate($page_limit);
        // dd($datas);
        $coco_category_datas = CocoCategoryModel::orderByRaw('ISNULL(`sort`),`sort` ASC')->get();
        
        $new_array = array();
        $new_array2 = array();
        
        foreach($datas as $key => $v){
            $new_array3 = array();
            $select_categorys = $v->select_category;
            $select_category = explode(",",$select_categorys);
            $v->select_category = $select_category;

            foreach($v->select_category as $kk => $vv){
                $new_array[$key] = $v;
                array_push($new_array2,$vv);
                $new_array[$key]->new_category = $new_array2;

                foreach($coco_category_datas as $key2 => $vvv){
                    if($v->select_category[$kk] == $vvv->id){
                        array_push($new_array3,$vvv->name);
                        $new_array[$key]->new_category = $new_array3;
                        $new_category = $new_array[$key]->new_category;
                    }
                }
                $implode_category = implode(" / ",$new_category); 
                $new_array[$key]->new_category = $implode_category;
            }
        }
        // dd($datas);
        return view('coco.coco_article.index', compact('header', 'field', 'datas'));
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

        $this->select_category();
        $this->field['select_category']['name']='select_category';
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
        //下拉式選單
        $this->select_category();
        $field = $this->field;
        $root = $this->role_name;
        $data = CocoArticleModel::find($id);
        $select_categorys = $data->select_category;
        $select_category = explode(",",$select_categorys);
        $data->new_select_category = $select_category;
        // dd($data);

        $data->start_at = date("Y-m-d\TH:i:s", strtotime($data->start_at));
        $data->end_at = date("Y-m-d\TH:i:s", strtotime($data->end_at));

        return view('coco.coco_article.edit', compact('header', 'method', 'route', 'field', 'root', 'data', 'id'));
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
        $CocoArticleModel->select_category = $data['new_select_category'];
        $data['image'] = $image_path;
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
