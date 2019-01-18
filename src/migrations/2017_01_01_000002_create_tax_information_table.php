<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTaxInformationTable extends Migration
{
    public $withinTransaction = false;

    protected $tax_information = 'tax_information';
    protected $users = 'users';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tax_information, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('information_id')->nullable();
            $table->string('information_type')->nullable();
            $table->integer('user_id')->nullable()->index();
        });

        Schema::table($this->tax_information, function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on($this->users)->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop($this->tax_information);
    }
}
