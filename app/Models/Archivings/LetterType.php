<?php

namespace App\Models\Archivings;

use App\Traits\ModelPrefixer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LetterType extends Model
{
    use HasFactory   ,  ModelPrefixer , SoftDeletes ;

    protected $prefix = "archive" , 
              $guarded = [] ;
}
