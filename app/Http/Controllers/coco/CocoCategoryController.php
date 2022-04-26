<?php

namespace App\Http\Controllers\coco;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CocoCategoryModel;
use App\Services\AdminRolesService;

class CocoCategoryController extends Controller
{
    private $role_name = 'coco_category';
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
            'title' => '網址',
            'type' => 'text',
            'name' => 'url',
            'placeholder' => '請輸入文章網址',
            'required' => TRUE
        ],
        [
            'title' => '分類層級',
            'type' => 'select',
            'name' => 'status',
            'option' => [
                0 => '一層',
                1 => '兩層'
            ],
        ],
        [
            'title' => '開啟方式',
            'type' => 'select',
            'name' => 'status',
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
        // $page_limit = 20;
        $header = '分類設定';
        $field = array('分類名稱','網址','分類層級','狀態','最後更新時間');
        // $datas = CocoCategoryModel::orderByRaw('ISNULL(`sort`),`sort` ASC')->orderBy('id','DESC')->paginate($page_limit);
        return view('coco.coco_category.index', compact('header', 'field'));
    }

    /**
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
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
