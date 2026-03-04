<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('custodian_info', function (Blueprint $table) {
            $table->timestamps();
            $table->softDeletes();  // idadagdag ang created_at at updated_at
        });
    }

    public function down(): void
    {
        Schema::table('custodian_info', function (Blueprint $table) {
            $table->dropTimestamps(); // tatanggalin kapag nag-rollback
        });
    }
};
