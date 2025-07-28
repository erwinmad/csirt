<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address');
            $table->text('user_agent');
            $table->string('country')->nullable();
            $table->string('route')->nullable();
            $table->timestamp('visited_at')->useCurrent();
            $table->index('ip_address');
        });
    }

    public function down()
    {
        Schema::dropIfExists('visitors');
    }
};