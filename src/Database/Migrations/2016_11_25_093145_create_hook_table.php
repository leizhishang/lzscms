<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('hook', function (Blueprint $table)
        {
            $table->string('name', 30)->default('')->comment(trans('lzscms::hook.name'));
            $table->string('module', 30)->default('manage')->comment(trans('lzscms::hook.module'));
            $table->text('description', 255)->comment(trans('lzscms::hook.description'));
            $table->tinyInteger('issystem', false)->default(0)->comment(trans('lzscms::hook.issystem'));
            $table->integer('times')->nullable()->comment(trans('lzscms::manage.times'));
            $table->text('document', 255)->comment(trans('lzscms::hook.document'));
            $table->primary('name');
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
        Schema::drop('hook');
    }
}
