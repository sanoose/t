<?php

namespace App\Models\Archivings;

use App\Traits\ModelPrefixer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    use HasFactory  ,  ModelPrefixer ;

    protected $prefix = "archive" , 
              $guarded = [] ;


 

}
