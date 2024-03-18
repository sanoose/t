<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string("user_id");
 
            $table->enum('user_create' ,   [ "true" , "false"]) ;
            $table->enum('user_edit' ,  [ "true" , "false"]) ;
            $table->enum('user_delete' ,[ "true" , "false"]) ;
            $table->enum('file_create' ,   [ "true" , "false" ]) ;
            $table->enum('file_edit' ,  [ "true" , "false" ]) ;
            $table->enum('file_delete' ,[ "true" , "false" ]) ;
  
            $table->softDeletes() ;   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
