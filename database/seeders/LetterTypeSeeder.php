<?php

namespace Database\Seeders;
 
use App\Models\Archivings\LetterType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LetterTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       LetterType::create([ "name" => "عادي" , ]) ;
       LetterType::create([ "name" => "مهم" , ]) ;
       LetterType::create([ "name" => "مهم جدا" , ]) ;
       LetterType::create([ "name" => "سري" , ]) ;
       LetterType::create([ "name" => "سري جدا" , ]) ;
    }
}
