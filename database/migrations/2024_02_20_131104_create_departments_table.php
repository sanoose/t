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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
    
            $table->bigInteger('last_inbox_number');
            $table->integer('last_inbox_year');
            $table->bigInteger('last_outbox_number');
            $table->integer('last_outbox_year');
            $table->bigInteger('user_id');
           
            $table->nestedSet();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('table', function (Blueprint $table) {
        //     $table->dropNestedSet();
        // });

        
        Schema::dropIfExists('departments');
    }
};
