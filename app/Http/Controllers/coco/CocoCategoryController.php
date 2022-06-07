<?php

namespace App\Http\Controllers\coco;

use App\Http\Controllers\Controller;
use App\Models\CocoCategoryModel;
use App\Http\Requests\CocoCategoryVaildate;
use Illuminate\Http\Request;
use App\Services\AdminRolesService;

class CocoCategoryController extends Controller
{
    private $role_name = 'coco_category';
    private $table = 'coco_category';
    private $admin_roles;

    public $field = [
        [
            'title' => '分類名稱',
            'type' => 'text',
            'name' => 'name',
            'placeholder' => '請輸入分類名稱',
            'required' => TRUE
        ],
        [
            'title' => '分類路徑',
            'type' => 'text',
            'name' => 'url',
            'placeholder' => '請輸入分類路徑',
            'required' => TRUE
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
    function __construct(AdminRolesService $admin_roles)
    {
        $this->admin_roles = $admin_roles;

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
        $page_limit = 5;
        $header = '分類設定';
        $field = array('分類名稱','url','狀態');
        $datas = CocoCategoryModel::orderByRaw('ISNULL(`sort`),`sort` ASC')->orderBy('id','DESC')->paginate($page_limit);
        
        return view('coco.coco_category.index', compact('header', 'datas', 'field'));
    }

    /**｀
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $header = '新增分類';
        $method = 'POST';
        $route = 'coco_category.store';
        $field = $this->field;
        $root = $this->role_name;

        return view('coco.coco_category.create', compact('header','field','root','route','method'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CocoCategoryVaildate $request)
    {
        $data = $request->all();

        if($request->status == 1){
            $data['sort'] = 0;
        }
        CocoCategoryModel::create($data);

        return redirect()->route('coco_category.index')->with('success', '資料儲存成功');
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
        $route = ['coco_category.update',$id];
        $field = $this->field;
        $root = $this->role_name;
        $data = CocoCategoryModel::find($id);
        $data->start_at = date("Y-m-d\TH:i:s", strtotime($data->start_at));
        $data->end_at = date("Y-m-d\TH:i:s", strtotime($data->end_at));

        return view('coco.coco_category.create', compact('header', 'method', 'route', 'field', 'root', 'data', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CocoCategoryVaildate $request, $id)
    {
        $CocoArticleModel = CocoCategoryModel::find($id);
        $data = $request->all();

        if($request->status !== 1){
            $data['sort'] = 0;
        }
        $CocoArticleModel->update($data);

        return redirect()->route('coco_category.index')->with('success', '資料儲存成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CocoCategoryModel::destroy($id);
        return redirect()->route('coco_category.index')->with('success', '資料刪除成功');
    }
    
    public function reorder(){
        $header = "排序";
        $action = 'shared/save_reorder';
        $method = 'POST';
        $table = $this->table;
        $datas = CocoCategoryModel::where('status',1)->orderBy('sort','ASC')->orderBy('id','DESC')->get();
        
        return view('coco.coco_category.reorder', compact('header', 'datas','table','action','method'));
    }
}
