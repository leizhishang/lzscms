<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommonRoleUriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('common_role_uri', function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->string('name')->nullable()->comment(lzs_lang('lzscms::public.name'));
            $table->string('ename')->nullable()->comment(lzs_lang('lzscms::public.ename'));
            $table->string('uri')->nullable()->comment('URI'.lzs_lang('lzscms::public.name'));
            $table->string('parent')->default('')->comment(lzs_lang('lzscms::public.parent'));
            $table->string('module', 30)->default('manage')->comment(lzs_lang('lzscms::public.module'));
            $table->text('remark')->nullable()->comment(lzs_lang('lzscms::public.remark'));
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('common_role_uri');
    }
}
