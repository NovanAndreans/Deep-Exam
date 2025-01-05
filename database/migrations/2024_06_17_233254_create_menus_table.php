<?php

use App\Models\Menu;
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
        $menu = new Menu();
        $user = new User();
        Schema::create('menus', function (Blueprint $table) use ($user, $menu) {
            $table->id();
            $table->foreignId('masterid')->nullable();
            $table->string('menunm');
            $table->string('menuroute')->nullable();
            $table->string('menuicon')->nullable();
            $table->integer('menuseq')->nullable();

            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('masterid')->references($menu->getKeyName())->on($menu->getTable())->onDelete('cascade');
            $table->foreign('created_by')->references($user->getKeyName())->on($user->getTable())->onDelete('cascade');
            $table->foreign('updated_by')->references($user->getKeyName())->on($user->getTable())->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
