<?php

namespace Database\Seeders;

use App\Models\role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create ([
            "id" => 1 ,
            'name' =>'s'  , 
            'email' =>'s' , 
            'password' => Hash::make("1") , 
            'user_level' =>'سوبر أدمن'  , 
            'department_id' =>'1'  , 
            'banned' => "false"           , 
            "added_by" => "1" 
        ]) ;

        role::create ([
            'user_id' => "1" , 
            'user_create' => "true" , 
            'user_edit' => "true" , 
            'user_delete' => "true" , 
            'file_create' => "true" , 
            'file_edit' => "true" , 
            'file_delete' => "true"  , 
        ]) ;


        User::create ([
            "id" => 2 ,
            'name' =>'s1'  , 
            'email' =>'s1' , 
            'password' => Hash::make("1") , 
            'user_level' =>'مشرف'  , 
            'department_id' =>'2'  , 
            'banned' => "false"  , 
            "added_by" => "1" 
        ]) ;

        role::create ([
            'user_id' =>  2 , 
            'user_create' => "true" , 
            'user_edit' => "true" , 
            'user_delete' => "true" , 
            'file_create' => "true" , 
            'file_edit' => "true" , 
            'file_delete' => "true"  , 
        ]) ;


        User::create ([
            "id" => 3 ,
            'name' =>'s2' , 
            'email' =>'s2' , 
            'password' => Hash::make("1") , 
            'user_level' =>'مستخدم'  , 
            'department_id' =>'3'  , 
            'banned' => "false"  , 
            "added_by" => "2" 
        ]) ;

        role::create ([
            'user_id' =>  3 , 
            'user_create' => "true" , 
            'user_edit' => "true" , 
            'user_delete' => "true" , 
            'file_create' => "true" , 
            'file_edit' => "true" , 
            'file_delete' => "true"  , 
        ]) ;


        User::create ([
            "id" => 4 ,
            'name' =>'s4' , 
            'email' =>'s4' , 
            'password' => Hash::make("1") , 
            'user_level' =>'مستخدم'  , 
            'department_id' =>'4'  , 
            'banned' => "false"  , 
            "added_by" => "2" 
        ]) ;

        role::create ([
            'user_id' =>  4 , 
            'user_create' => "true" , 
            'user_edit' => "true" , 
            'user_delete' => "true" , 
            'file_create' => "true" , 
            'file_edit' => "true" , 
            'file_delete' => "true"  , 
        ]) ;

    }
}
