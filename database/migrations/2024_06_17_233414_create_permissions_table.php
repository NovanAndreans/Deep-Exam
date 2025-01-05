<?php

use App\Models\Feature;
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
        $feature = new Feature();
        $type = new Type();
        Schema::create('permissions', function (Blueprint $table) use ($user, $feature, $type) {
            $table->id();
            $table->foreignId('role');
            $table->foreignId('permisfeatid');
            $table->boolean('hasaccess')->default(true);

            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references($user->getKeyName())->on($user->getTable())->onDelete('cascade');
            $table->foreign('updated_by')->references($user->getKeyName())->on($user->getTable())->onDelete('cascade');
            $table->foreign('permisfeatid')->references($feature->getKeyName())->on($feature->getTable())->onDelete('cascade');
            $table->foreign('role')->references($type->getKeyName())->on($type->getTable())->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
