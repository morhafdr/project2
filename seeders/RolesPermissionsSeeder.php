<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */


    public function run(): void
    {
        $superAdminRole=Role::create(['name'=>'superAdmin']);
        $adminRole=Role::create(['name'=>'admin']);
        $deliveryRole=Role::create(['name'=>'delivery']);
        $officer=Role::create(['name'=>'officer']);
        $clientRole=Role::create(['name'=>'client']);

        $permissions=[
            'view-employees','create-employee','show-employee','update-employee','delete-employee',
            'view-offices','create-office','show-office','update-office','delete-office',
            'view-trucks','create-truck','show-truck','update-truck','delete-truck',
            'view-drivers','create-driver','show-driver','update-driver','delete-driver',
            'view-orders','create-order','show-order','update-order','delete-order',
            'view-invoices','create-invoice','show-invoice','update-invoice','delete-invoice',
            'view-warehouses','create-warehouse','show-warehouse','update-warehouse','delete-warehouse',
            'rate-office', 'view-reports'
            ];

        foreach ($permissions as $permission)
        {
            Permission::findOrCreate($permission,'web');
        }

        $superAdminRole->syncPermissions($permissions);


        $adminRole->syncPermissions([
            'view-offices','create-office','show-office','update-office','delete-office',
            'view-trucks','create-truck','show-truck','update-truck','delete-truck',
            'view-drivers','create-driver','show-driver','update-driver','delete-driver',
            'view-orders','create-order','show-order','update-order','delete-order',
            'view-invoices','create-invoice','show-invoice','update-invoice','delete-invoice',
            'view-warehouses','show-warehouse', 'rate-office'
        ]);

        $deliveryRole->syncPermissions();
        $officer->syncPermissions([
            'view-offices','show-office',  'view-trucks','show-truck',
            'view-orders','create-order','show-order','update-order','delete-order',
            'view-invoices','create-invoice','show-invoice','update-invoice','delete-invoice',
            'view-warehouses','show-warehouse','rate-office'
        ]);
        $clientRole->syncPermissions([
            'view-offices','show-office','create-order','show-order','update-order','delete-order',
            'show-invoice', 'rate-office','create-order'
        ]);

        $superAdminUser=User::create([
            'email'=>'superAdmin@gmail.com',
            'first_name'=>'ahmed',
            'last_name'=>'ali',
            'father_name'=>'ali',
            'mother_name'=>'sara',
            'national_number'=>'13060056045',
            'phone'=>'0996854712',
            'password'=>bcrypt('123456'),
        ]);


        $superAdminUser->assignRole($superAdminRole);
        $superAdminUser->givePermissionTo($permissions);
    }
}
