<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\role_has_permissions;
use Illuminate\Support\Facades\DB;

class EditPermissionUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $config_menu = config('adminlte.menu');

        Permission::where('status',true)
        			->update(['status'=>false]);

        $function_role = [
           'list',
           'create',
           'edit',
           'delete'
        ];
        $permissions = array();
        foreach($config_menu as $k=>$v):
            if($k !== 0):
                foreach($function_role as $kkk=>$vvv):
                    $permissions[] = array(
                        'level'     =>  1,
                        'name'      =>  $v['role_name'].'-'.$vvv,
                        'guard_name'=>  'web',
                        'status'    =>  true
                    );
                    foreach($v['submenu'] as $kk=>$vv):
                        $permissions[] = array(
                            'level'     =>  2,
                            'name'      =>  $vv['role_name'].'-'.$vvv,
                            'guard_name'=>  'web',
                            'status'    =>  true
                        );
                        if(isset($vv['submenu']) && $vv['submenu']):
                            foreach($vv['submenu'] as $kkkk=>$vvvv):
                                $permissions[] = array(
                                    'level'     =>  3,
                                    'name'      =>  $vvvv['role_name'].'-'.$vvv,
                                    'guard_name'=>  'web',
                                    'status'    =>  true
                                );
                            endforeach;
                        endif;
                    endforeach;
                endforeach;
            endif;
        endforeach;
        foreach($permissions as $permission):
			$data = Permission::get()
					->where('name',$permission['name'])
					->first();
            if($data):
                $update_data = Permission::find($data['id']);
            	$update_data->status = true;
    			$update_data->save();
            else:
                Permission::create(
                    [
                        'level'     =>  $permission['level'],
                        'name'      =>  $permission['name'],
                        'guard_name'=>  $permission['guard_name'],
                        'status'    =>  true,
                    ]
                );
            endif;
		endforeach;
        $role = Role::where(['name' => 'Admin'])
                    ->first();
        DB::table('role_has_permissions')
                ->where('role_id',$role->id)
                ->delete();
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);
    }
}
