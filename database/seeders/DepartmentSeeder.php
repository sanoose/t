<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        Department::create([
            "id" => "1" ,
            "name" => "وزارة الداخلية" ,
            "last_inbox_number" => "10" ,
            "last_inbox_year" => "2024" ,
            "last_outbox_number" => "55" ,
            "last_outbox_year" => "2024" ,
            "user_id" => "1" ,
            "parent_id" => null ,
        ]) ;

        Department::create([
            "id" => "2" ,
            "name" => "مركز المعلومات والتوثيق" ,
            "last_inbox_number" => "10" ,
            "last_inbox_year" => "2024" ,
            "last_outbox_number" => "55" ,
            "last_outbox_year" => "2024" ,
            "parent_id" => "1" ,
            "user_id" => "1" ,
        ]) ;

        Department::create([
            "id" => "3" ,
            "name" => "هندسة البرمجيات" ,
            "last_inbox_number" => "10" ,
            "last_inbox_year" => "2024" ,
            "last_outbox_number" => "55" ,
            "last_outbox_year" => "2024" ,
            "user_id" => "1" ,
            "parent_id" => "2" ,
        ]) ;


        Department::create([
            "id" => "4" ,
            "name" => "فرع مركز المعلومات" ,
            "last_inbox_number" => "10" ,
            "last_inbox_year" => "2024" ,
            "last_outbox_number" => "55" ,
            "last_outbox_year" => "2024" ,
            "user_id" => "1" ,
            "parent_id" => "2" ,
        ]) ;

        Department::create([
            "id" => "5" ,
            "name" => "فرع فرع مركز المعلومات" ,
            "last_inbox_number" => "10" ,
            "last_inbox_year" => "2024" ,
            "last_outbox_number" => "55" ,
            "last_outbox_year" => "2024" ,
            "user_id" => "1" ,
            "parent_id" => "4" ,
        ]) ;


        Department::create([
            "id" => "6" ,
            "name" => "فرع     هندسة البرمجيات" ,
            "last_inbox_number" => "10" ,
            "last_inbox_year" => "2024" ,
            "last_outbox_number" => "55" ,
            "last_outbox_year" => "2024" ,
            "user_id" => "1" ,
            "parent_id" => "3" ,
        ]) ;

        Department::create([
            "id" => "7" ,
            "name" => "فرع رئيسي  " ,
            "last_inbox_number" => "10" ,
            "last_inbox_year" => "2024" ,
            "last_outbox_number" => "55" ,
            "last_outbox_year" => "2024" ,
            "user_id" => "1" ,
            "parent_id" => "" ,
        ]) ;

        Department::create([
            "id" => "8" ,
            "name" => "فرع الفرع الرئيسي  " ,
            "last_inbox_number" => "10" ,
            "last_inbox_year" => "2024" ,
            "last_outbox_number" => "55" ,
            "last_outbox_year" => "2024" ,
            "user_id" => "1" ,
            "parent_id" => "7" ,
        ]) ;


        
    }
}
