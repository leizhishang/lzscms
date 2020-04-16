<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManageMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('manage_menu', function (Blueprint $table)
        {
            $table->increments('id')->comment('ID');
            $table->string('name', 30)->default('')->comment(lzs_lang('lzscms::public.name'));
            $table->string('ename', 30)->default('')->comment(lzs_lang('lzscms::public.ename'));
            $table->string('icon', 50)->default('')->comment(lzs_lang('lzscms::public.icon'));
            $table->string('url')->default('')->comment('url');
            $table->tinyInteger('level', false)->default(0)->comment(lzs_lang('lzscms::public.level'));
            $table->string('parent', 30)->default('root')->comment(lzs_lang('lzscms::public.parent'));
            $table->string('parents', 30)->default('')->comment(lzs_lang('lzscms::public.parents'));
            $table->string('module', 30)->default('manage')->comment(lzs_lang('lzscms::public.module'));
            // $table->timestamps();
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
        Schema::drop('manage_menu');
    }
}
