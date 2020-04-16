<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommonConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('common_config', function (Blueprint $table) 
        {
            $table->increments('id')->comment('ID');
            $table->string('name', 30)->default('')->comment(lzs_lang('lzscms::public.name'));
            $table->string('namespace', 30)->default('')->comment(lzs_lang('lzscms::public.namespace'));
            $table->text('value', 255)->comment(lzs_lang('lzscms::public.cvalue'));
            $table->enum('vtype', ['string','array','object'])->default('string')->nullable();
            $table->text('desc', 255)->comment(lzs_lang('lzscms::public.desc'));
            $table->tinyInteger('issystem', false)->default(0)->comment(lzs_lang('lzscms::public.issystem'));
            $table->unique(['name','namespace']);
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
        Schema::drop('common_config');
    }
}
