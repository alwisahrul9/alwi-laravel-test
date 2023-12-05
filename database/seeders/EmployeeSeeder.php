<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employee::create([
            'first_name' => 'Alwi',
            'last_name' => 'Sahrul',
            'email' => 'alwisahrul9@gmail.com',
            'phone' => '081523652145',
            'company_id' => 1
        ]);
    }
}
