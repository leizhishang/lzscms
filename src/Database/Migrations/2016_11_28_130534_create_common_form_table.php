<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommonFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('common_form', function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->string('name')->nullable()->comment(lzs_lang('lzscms::public.name'));
            $table->text('setting')->comment();
            $table->string('module', 30)->default('site')->comment(lzs_lang('lzscms::public.module'));
            $table->string('table', 30)->comment(lzs_lang('lzscms::public.table'));
            $table->integer('relatedid')->nullable()->comment();
            $table->integer('times')->nullable()->comment(lzs_lang('lzscms::public.times'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('common_form');
    }
}
