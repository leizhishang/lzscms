<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommonAreaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('common_area', function (Blueprint $table) 
        {
            $table->increments('areaid')->comment('ID');
            $table->string('name')->nullable()->comment(lzs_lang('lzscms::public.name'));
            $table->string('joinname', 50)->default('')->comment();
            $table->string('parentid', 50)->default('')->comment();
            $table->string('vieworder', 50)->default('')->comment();
            $table->string('zip', 50)->default('')->comment();
            $table->string('initials', 50)->default('')->comment();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('common_area');
    }
}
