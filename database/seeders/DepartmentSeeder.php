<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('departments')->insert([
    ['name' => 'Phòng nhân sự'],
    ['name' => 'Phòng tổ chức'],
    ['name' => 'Phòng kĩ thuật'],
    ['name' => 'Phòng bảo mật'],
    ['name' => 'Phòng tài chính'],
        ],['name']);

    }
}
