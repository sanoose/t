<?php

use App\Models\Archivings\Subject;
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

     

          if(!Schema::hasTable((new Subject)->getTable(),)) {
            Schema::create((new Subject)->getTable(), function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('code');
                $table->nestedSet();
                $table->softDeletes();
                $table->timestamps();
            });
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists((new Subject)->getTable());
    }
};
