<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_data = array(
            [
                'name'      => 'Eric Chou',
                'email'     => 'weichihchou@tvbs.com.tw',
                'password'  => bcrypt('eric890424')
            ],
            [
                'name'      => 'Dev001',
                'email'     => 'dev001@tvbs.com.tw',
                'password'  => bcrypt('dev001dev001dev001')
            ]
        );
        $role = Role::create(['name' => 'Admin']);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);
        foreach($user_data as $v):
            $user = User::create(
                [
                    'name'      => $v['name'],
                    'email'     => $v['email'],
                    'password'  => $v['password']
                ]
            );
            $user->assignRole([$role->id]);
        endforeach;
    }
}