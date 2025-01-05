<?php

use App\Models\Type;
use App\Models\User;
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
        $type = new Type();
        $user = new User();
        Schema::create('types', function (Blueprint $table) use ($type, $user) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('name');
            $table->integer('seq')->nullable();
            $table->text('desc')->nullable();
            $table->foreignId('master_id')->nullable();

            $table->timestamps();

            $table->foreign('master_id')->references($type->getKeyName())->on($type->getTable())->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('types');
    }
};
