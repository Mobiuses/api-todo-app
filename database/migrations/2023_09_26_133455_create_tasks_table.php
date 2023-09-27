<?php

use App\Modules\Core\ORM\Enums\TaskPriorityEnum;
use App\Modules\Core\ORM\Enums\TaskStatusEnum;
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
        Schema::create('tasks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('parent_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->enum('status', TaskStatusEnum::values());
            $table->enum('priority', TaskPriorityEnum::values());
            $table->string('title');
            $table->text('description');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
