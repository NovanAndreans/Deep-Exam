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
        $user = new User();
        $type = new Type();
        Schema::create('users', function (Blueprint $table) use ($user, $type) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->foreignId('role_id');
            $table->foreignId('gender_id');

            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('role_id')->references($type->getKeyName())->on($type->getTable())->onDelete('cascade');
            $table->foreign('gender_id')->references($type->getKeyName())->on($type->getTable())->onDelete('cascade');
            $table->foreign('created_by')->references($user->getKeyName())->on($user->getTable())->onDelete('cascade');
            $table->foreign('updated_by')->references($user->getKeyName())->on($user->getTable())->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
