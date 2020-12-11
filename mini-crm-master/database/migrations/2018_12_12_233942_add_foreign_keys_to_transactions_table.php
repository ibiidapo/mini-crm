<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('transactions', function (Blueprint $table) {
            $table->foreign(['client_id'])
                  ->references('id')
                  ->on('clients')
                  ->onUpdate('restrict')
                  ->onDelete('restrict');
        });
        Schema::enableForeignKeyConstraints();
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
        });
        Schema::enableForeignKeyConstraints();
    }
}
