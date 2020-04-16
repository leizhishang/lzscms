<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHookInjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('hook_inject', function (Blueprint $table)
        {
            $table->increments('id')->comment('ID');
            $table->string('hook_name', 50)->default('')->comment(trans('lzscms::hook.name'));
            $table->string('alias', 100)->default('')->comment(trans('lzscms::hook.alias'));
            $table->string('files', 150)->default('')->comment(trans('lzscms::hook.files'));
            $table->string('class', 50)->default('root')->comment(trans('lzscms::hook.class'));
            $table->string('fun', 50)->default('root')->comment(trans('lzscms::hook.fun'));
            $table->text('description', 255)->comment(trans('lzscms::hook.description'));
            $table->tinyInteger('issystem', false)->default(0)->comment(trans('lzscms::hook.issystem'));
            $table->integer('times')->nullable()->comment(trans('lzscms::public.times'));
            $table->unique(['hook_name', 'alias']);
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
        Schema::drop('hook_inject');
    }
}
