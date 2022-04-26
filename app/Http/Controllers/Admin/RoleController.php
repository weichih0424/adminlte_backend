<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Services\AdminRolesService;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    private $role_name = 'admin_roles';
    private $admin_roles;

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
    public function index(Request $request)
    {
        $roles = Role::orderBy('id','DESC')->where('name','!=','Admin')->paginate(5);
        return view('admin.roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        foreach(config('adminlte.menu') as $k=>$v):
            if($k !== 0):
                $permission[] = $v;
            endif;
        endforeach;
        return view('admin.roles.create',compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        $permission_function = array('list','create','edit','delete');
        $permission_arr = $request->input('permission');
        foreach($request->input('permission') as $k=>$v):
            $array = explode('_',explode('-',$v)[0]);
            $string = '';
            for($i = 0; $i < (count($array)-1); $i++):
                if($string):
                    $string = $string.'_'.$array[$i];
                else:
                    $string = $array[$i];
                endif;
                foreach($permission_function as $vv):
                    if(!in_array($string.'-'.$vv,$permission_arr)):
                        $permission_arr[] = $string.'-'.$vv;
                    endif;
                endforeach;
            endfor;
            if(!in_array($v,$permission_arr)):
                $permission_arr[] = $v;
            endif;
        endforeach;
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($permission_arr);

        return redirect()->route('roles.index')
                        ->with('success','Role created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        foreach(config('adminlte.menu') as $k=>$v):
            if($k !== 0):
                $permission[] = $v;
            endif;
        endforeach;
        $rolePermissions = DB::table("role_has_permissions")
                                ->join("permissions","role_has_permissions.permission_id","=","permissions.id")
                                ->where("role_has_permissions.role_id",$id)
                                ->pluck('permissions.name','permissions.name')
                                ->all();

        return view('admin.roles.show',compact('role','permission','rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        foreach(config('adminlte.menu') as $k=>$v):
            if($k !== 0):
                $permission[] = $v;
            endif;
        endforeach;
        $rolePermissions = DB::table("role_has_permissions")
                                ->join("permissions","role_has_permissions.permission_id","=","permissions.id")
                                ->where("role_has_permissions.role_id",$id)
                                ->pluck('permissions.name','permissions.name')
                                ->all();
        return view('admin.roles.edit',compact('role','permission','rolePermissions'));
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
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);

        $permission_function = array('list','create','edit','delete');
        $permission_arr = $request->input('permission');
        foreach($request->input('permission') as $k=>$v):
            $array = explode('_',explode('-',$v)[0]);
            $string = '';
            for($i = 0; $i < (count($array) - 1); $i++):
                if($string):
                    $string = $string.'_'.$array[$i];
                else:
                    $string = $array[$i];
                endif;
                foreach($permission_function as $vv):
                    if(!in_array($string.'-'.$vv,$permission_arr)):
                        $permission_arr[] = $string.'-'.$vv;
                    endif;
                endforeach;
            endfor;
            if(!in_array($v,$permission_arr)):
                $permission_arr[] = $v;
            endif;
        endforeach;
        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();
        
        $role->syncPermissions($permission_arr);

        return redirect()->route('roles.index')
                        ->with('success','Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();
        return redirect()->route('roles.index')
                        ->with('success','Role deleted successfully');
    }
}
