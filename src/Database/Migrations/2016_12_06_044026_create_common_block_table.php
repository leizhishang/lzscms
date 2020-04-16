<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommonBlockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('common_block', function (Blueprint $table) 
        {
            $table->increments('id')->comment('ID');
            $table->string('name')->nullable()->comment(lzs_lang('lzscms::public.name'));
            $table->integer('times')->nullable()->comment(lzs_lang('lzscms::public.times'));
            $table->text('content')->nullable()->comment();
            $table->tinyInteger('isopen', false)->default(0)->nullable()->comment(lzs_lang('lzscms::public.status'));
            $table->string('type')->nullable()->comment();
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
        Schema::drop('common_block');
    }
}
