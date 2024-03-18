<?php

namespace App\Models\Archivings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelPrefixer;
use Kalnoy\Nestedset\NodeTrait;

class Subject extends Model
{
    use HasFactory ,
        ModelPrefixer  , NodeTrait ;
    
    protected $prefix = "archive" , 
    $guarded = [] ;
}
