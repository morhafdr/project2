<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user1=User::create([
            'email'=>'ahmad@gmail.com',
            'first_name'=>'ahmed',
            'last_name'=>'ali',
            'father_name'=>'ali',
            'mother_name'=>'sahar',
            'national_number'=>'13060056222',
            'phone'=>'0996854722',
            'password'=>bcrypt('123456789'),
        ]);
        $user1->assignRole('officer');
       Employee::create([
            'user_id' => $user1->id, // Existing user ID
            'office_id' => 2, // Existing office ID
            'join_date' => Carbon::create('2021', '01', '15'),
            'salary' => 30000,
        ]);
        // Second Employee and User
        $user2 = User::create([
            'email' => 'sara@gmail.com',
            'first_name' => 'Sara',
            'last_name' => 'Kamal',
            'father_name' => 'Kamal',
            'mother_name' => 'Leila',
            'national_number' => '13060056223',
            'phone' => '0996854766',
            'password' => bcrypt('987654321'),
        ]);

        // Assign role to user2
        $user2->assignRole('officer');

        // Create employee record for user2
        Employee::create([
            'user_id' => $user2->id,
            'office_id' => 1, // Make sure the office with ID 2 exists
            'join_date' => Carbon::create('2020', '06', '10'),
            'salary' => 35000,
        ]);

        // Second Employee and User
        $user3 = User::create([
            'email' => 'rami@gmail.com',
            'first_name' => 'rami',
            'last_name' => 'Kamal',
            'is_online' => 1,
            'father_name' => 'Kamal',
            'mother_name' => 'Leila',
            'national_number' => '13060056288',
            'phone' => '0996854744',
            'password' => bcrypt('987654321'),
        ]);

        // Assign role to user2
        $user3->assignRole('delivery');

        // Create employee record for user2
        Employee::create([
            'user_id' => $user3->id,
            'office_id' => 1, // Make sure the office with ID 2 exists
            'join_date' => Carbon::create('2020', '06', '10'),
            'salary' => 35000,
        ]);

        $user4 = User::create([
            'email' => 'morhaf@gmail.com',
            'first_name' => 'rami',
            'last_name' => 'Kamal',
            'father_name' => 'Kamal',
            'mother_name' => 'Leila',
            'national_number' => '13060056289',
            'phone' => '0996854744',
            'password' => bcrypt('987654321'),
        ]);

        // Assign role to user2
        $user4->assignRole('delivery');

        // Create employee record for user2
        Employee::create([
            'user_id' => $user4->id,
            'office_id' => 1, // Make sure the office with ID 2 exists
            'join_date' => Carbon::create('2020', '06', '10'),
            'salary' => 35000,
        ]);
    }
}
