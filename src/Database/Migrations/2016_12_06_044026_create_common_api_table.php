<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommonApiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('common_api', function (Blueprint $table) 
        {
            $table->increments('id')->comment('ID');
            $table->string('name')->nullable()->comment(lzs_lang('lzscms::public.name'));
            $table->integer('addtimes')->nullable()->comment(lzs_lang('lzscms::public.times'));
            $table->integer('edittimes')->nullable()->comment(lzs_lang('lzscms::public.times'));
            $table->tinyInteger('status', false)->default(0)->nullable()->comment(lzs_lang('lzscms::public.status'));
            $table->string('secret')->nullable()->comment();
            $table->string('appid')->nullable()->comment();
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
        Schema::drop('common_api');
    }
}
