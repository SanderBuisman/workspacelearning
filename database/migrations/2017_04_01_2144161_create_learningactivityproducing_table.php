<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLearningactivityproducingTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('learningactivityproducing', function (Blueprint $table): void {
            $table->integer('lap_id', true);
            $table->integer('wplp_id')->index('fk_LearningActivityProducing_WorkplaceLearningPeriod1_idx');
            $table->float('duration', 10, 0);
            $table->string('description', 100);
            $table->date('date');
            $table->integer('prev_lap_id')->nullable()->index('fk_LearningActivityProducing_LearningActivityProducing1_idx');
            $table->integer('res_person_id')->nullable()->index('fk_LearningActivityProducing_ResourcePerson1_idx');
            $table->integer('res_material_id')->nullable()->index('fk_LearningActivityProducing_ResourceMaterial1_idx');
            $table->string('res_material_detail', 75)->nullable();
            $table->integer('category_id')->index('fk_LearningActivityProducing_Category1_idx');
            $table->integer('difficulty_id')->index('fk_LearningActivityProducing_Difficulty1_idx');
            $table->integer('status_id')->index('fk_LearningActivityProducing_Status1_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('learningactivityproducing');
    }
}
