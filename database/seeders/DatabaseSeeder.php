<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Archivings\LetterType;
use App\Models\hiring_place;
 
use App\Models\role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
            $this->call ([
                UserSeeder::class ,
                DepartmentSeeder::class ,
                LetterTypeSeeder::class ,
                SubjectsSeeder::class ,
          
                // CompaySeeder::class ,
          
            ]) ;
        


    }
}
