<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReorderColumnsInCastTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('casts', function (Blueprint $table) {
            // Hapus kolom 'name'
            $table->dropColumn('name');
        });

        // Tambahkan kembali kolom 'name' setelah 'id'
        Schema::table('casts', function (Blueprint $table) {
            $table->string('name')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('casts', function (Blueprint $table) {
            // Drop kolom 'name' yang baru ditambahkan
            $table->dropColumn('name');
        });
    }
}
