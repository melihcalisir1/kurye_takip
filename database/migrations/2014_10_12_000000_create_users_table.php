<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
<<<<<<< HEAD
    /**
     * Run the migrations.
     */
    public function up(): void
=======
    public function up()
>>>>>>> 50735df (Kurye Takip projesi: login, rol bazlı yönlendirme, modern arayüz ve seeder eklendi)
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
<<<<<<< HEAD
            $table->string('phone')->nullable()->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'kurye', 'şirket_sahibi', 'musteri'])->default('musteri');
            $table->enum('status', ['aktif', 'pasif', 'banli'])->default('aktif');
            $table->decimal('location_lat', 10, 7)->nullable();
            $table->decimal('location_lng', 10, 7)->nullable();
            $table->string('avatar')->nullable();
=======
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['admin', 'restaurant', 'courier'])->default('courier');
            $table->rememberToken();
>>>>>>> 50735df (Kurye Takip projesi: login, rol bazlı yönlendirme, modern arayüz ve seeder eklendi)
            $table->timestamps();
        });
    }

<<<<<<< HEAD
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
=======
    public function down()
    {
        Schema::dropIfExists('users');
    }
}; 
>>>>>>> 50735df (Kurye Takip projesi: login, rol bazlı yönlendirme, modern arayüz ve seeder eklendi)
