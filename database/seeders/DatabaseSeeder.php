<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make(12345),
        ]);

        // for ($index = 1; $index < 100; $index++) {
        //     $name = fake()->name();
        //     User::create([
        //         'name' => $name,
        //         'email' => fake()->safeEmail(),
        //         'password' => Hash::make($name),
        //         'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        //     ]);
        // }

        $permissions = [
            'create products',
            'edit products',
            'delete products',
            'view products',

            'create users',
            'edit users',
            'delete users',
            'view users',

            'create roles',
            'edit roles',
            'delete roles',
            'view roles',

            'create permissions',
            'edit permissions',
            'delete permissions',
            'view permissions',

            'create categories',
            'edit categories',
            'delete categories',
            'view categories',
            // Thêm các quyền mới tại đây
        ];

        // Tạo hoặc cập nhật các quyền
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Tạo vai trò admin nếu chưa tồn tại
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Gán tất cả các quyền cho vai trò admin
        $adminRole->syncPermissions(Permission::all());

        // Tạo hoặc cập nhật người dùng admin
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password') // Đảm bảo thay đổi mật khẩu này
            ]
        );

        // Gán vai trò admin cho người dùng
        $adminUser->assignRole($adminRole);
    }
}
