<?php

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [ 
            [
                'title' => ' ایجاد کاربر',
                'slug' => 'create_user',
              ],
              [
                  'title' => ' ویرایش کاربر',
                  'slug' => 'edit_user',
              ],
              [
                  'title' => ' حذف کاربر',
                  'slug' => 'delete_user',
              ],
              [
                  'title' => ' خواندن کاربر',
                  'slug' => 'read_user',
              ],
            [ 
              'title' => 'ایجاد تگ',
              'slug' => 'create_tag',
            ],
            [ 
              'title' => 'ویرایش تگ',
              'slug' => 'edit_tag',
            ],
            [ 
                'title' => 'حذف تگ',
                'slug' => 'delete_tag',
            ],
            [ 
                'title' => 'خواندن تگ',
                'slug' => 'read_tag',
            ],
            [
              'title' => ' ایجادآیکون',
              'slug' => 'create_icon',
            ],
            [
                'title' => ' ویرایش آیکون',
                'slug' => 'edit_icon',
            ],
            [
                'title' => ' حذف آیکون',
                'slug' => 'delete_icon',
            ],
            [
                'title' => ' خواندن آیکون',
                'slug' => 'read_icon',
            ],
            [
              'title' => 'ایجاد دسته بندی',
              'slug' => 'create_category',
            ] ,
            [
                'title' => 'ویرایش دسته بندی',
                'slug' => 'edit_category',
            ],
            [
                'title' => 'حذف دسته بندی',
                'slug' => 'delete_category',
            ],
            [
                'title' => 'خواندن دسته بندی',
                'slug' => 'read_category',
            ],
            [
              'title' => 'ایجاد پست',
              'slug' => 'create_post',
            ],
            [
                'title' => 'ویرایش پست',
                'slug' => 'edit_post',
            ],
            [
                'title' => 'حذف پست',
                'slug' => 'delete_post',
            ],
            [
                'title' => 'خواندن پست',
                'slug' => 'read_post',
            ],
            [
              'title' => ' ایجاد نقش',
              'slug' => 'create_role',
            ],
            [
                'title' => ' ویرایش نقش',
                'slug' => 'edit_role',
            ],
            [
                'title' => ' حذف نقش',
                'slug' => 'delete_role',
            ],
            [
                'title' => ' خواندن نقش',
                'slug' => 'read_role',
            ],
            [
              'title' => 'ایجاد دسترسی',
              'slug' => 'create_permission',
            ],
            [
                'title' => 'ویرایش دسترسی',
                'slug' => 'edit_permission',
            ],
            [
                'title' => 'حذف دسترسی',
                'slug' => 'delete_permission',
            ],
            [
                'title' => 'خواندن دسترسی',
                'slug' => 'read_permission',
            ],
          ];

          foreach($permissions as $permission)
          {
              Permission::create([
               'title' => $permission['title'], 
               'slug' => $permission['slug']
             ]);
           }
           $admin = Role::create(['title' => 'super-admin','slug' => 'super-admin',]);
           $adminOperator = User::query()->create([
            'name' => 'super-admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => bcrypt('123456789'),
            'phone' => '123456789',
            'type' => 'admin',
            'status' => 1,
            'remember_token' => Str::random(10),
        ]);
        // $roles = [0,1,2,3,4];
        // $admin->permissions()->attach($roles);

        // $adminOperator->roles()->attach($admin);
    }
}
