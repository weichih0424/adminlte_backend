<?php

namespace App\Http\Controllers\coco;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CocoNavModel;
use App\Services\AdminRolesService;
use App\Http\Requests\CocoNavVaildate;

class CocoNavController extends Controller
{
    private $role_name = 'coco_nav';
    private $admin_roles;

    public $field = [
        [
            'title' => '導覽列名稱',
            'type' => 'text',
            'name' => 'name',
            'placeholder' => '請輸入分類名稱',
            'required' => TRUE
        ],
        [
            'title' => '網址',
            'type' => 'text',
            'name' => 'url',
            'placeholder' => '請輸入文章網址',
            'required' => TRUE
        ],
        'position'=>[
            'title' => '導覽列層級',
            'type' => 'select',
            'name' => 'position',
            'option' => [
                0 => '共一層',
                1 => '共兩層'
            ],
        ],
        [
            'title' => '開啟方式',
            'type' => 'select',
            'name' => 'blank',
            'option' => [
                0 => '同頁開啟',
                1 => '開新分頁'
            ],
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

    public function index()
    {   
        //isset()判斷有無該變數，empty()判斷該值是否為空值
        $page_limit = 20;
        $header = isset($_GET['parent_id'])?'次導覽列頁設定':'主導覽列頁設定';
        $field = array('導覽列名稱','網址','分類層級','狀態','最後更新時間');

        if(isset($_GET['parent_id']) && !empty($_GET['parent_id'])){
            // $datas = CocoCategoryModel::where('parent_id',$_GET['parent_id'])->orderByRaw('ISNULL(`sort`),`sort` ASC')->orderBy('id','DESC')->paginate($page_limit);
            $datas = CocoNavModel::where('parent_id',$_GET['parent_id'])->where('position',2)->orderByRaw('ISNULL(`sort`),`sort` ASC')->orderBy('id','DESC')->paginate($page_limit)->appends(['parent_id'=>$_GET['parent_id']]);
        }else{
            $datas = CocoNavModel::where('position', '<', 2)->orderByRaw('ISNULL(`sort`),`sort` ASC')->orderBy('id','DESC')->paginate($page_limit);
        }

        return view('coco.coco_nav.index', compact('header', 'datas', 'field'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $header = isset($_GET['parent_id'])?'新增次導覽列頁':'新增主導覽列頁';
        $method = 'POST';
        if(isset($_GET['parent_id'])){
            unset($this->field['position']);
            array_push($this->field, [
                'type' => 'hidden',
                'name' => 'parent_id',
                'value' => $_GET['parent_id'],
            ]);
        }

        
        $route = 'coco_nav.store';
        $field = $this->field;
        $root = $this->role_name;

        return view('coco.coco_nav.create', compact('header','method','route','field','root'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CocoNavVaildate $request)
    {
        $data = $request->all();
        if($request->status == 1){
            $data['sort'] = 0;
        }
        if(!isset($data['position'])){
            $data['position'] = 2;
        }
        CocoNavModel::create($data);
        $new_store_data = CocoNavModel::orderByDesc('id')->limit(1)->get()[0];
        if($data['position'] !== 2){
            return redirect()->route('coco_nav.index')->with('success', '資料儲存成功');
        }else{
            return redirect()->route('coco_nav.index',['parent_id'=>$new_store_data->parent_id])->with('success', '資料儲存成功');
        }
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
        $data = CocoNavModel::find($id);
        if($data->position == 2){
            $header = '編輯次導覽列頁';
            unset($this->field['position']);
        }else{
            $header = '編輯主導覽列頁';
        }
        $method = 'PATCH';
        $route = ['coco_nav.update',$id];
        $field = $this->field;
        $root = $this->role_name;

        return view('coco.coco_nav.create', compact('data','header','method','route','field','root','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CocoNavVaildate $request, $id)
    {
        $CocoCategoryModel = CocoNavModel::find($id);
        $data = $request->all();

        if($request->status !== 1){
            $data['sort'] = 0;
        }
        $CocoCategoryModel->update($data);

        if($CocoCategoryModel->position !== 2){
            return redirect()->route('coco_nav.index')->with('success', '資料儲存成功');
        }else{
            return redirect()->route('coco_nav.index',['parent_id'=>$CocoCategoryModel->parent_id])->with('success', '資料儲存成功');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $CocoCategoryModel = CocoNavModel::find($id);
        $CocoCategoryModel->delete();
        $data = CocoNavModel::where('parent_id', '=', $id);
        $data->delete();

        if($CocoCategoryModel->position !== 2){
            return redirect()->route('coco_nav.index')->with('success', '資料刪除成功');
        }else{
            return redirect()->route('coco_nav.index',['parent_id'=>$CocoCategoryModel->parent_id])->with('success', '資料刪除成功');
        }
    }
}
