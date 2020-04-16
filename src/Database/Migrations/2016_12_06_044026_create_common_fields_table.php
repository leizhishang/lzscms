<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommonFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('common_fields', function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->string('name')->nullable()->comment(lzs_lang('lzscms::public.name'));
            $table->string('fieldname')->nullable()->comment();
            $table->string('fieldtype')->nullable()->comment();
            $table->string('relatedtable')->nullable()->comment();
            $table->string('relatedid')->nullable()->comment();
            $table->string('module')->nullable()->comment();
            $table->tinyInteger('ismain', false)->nullable(0)->comment();
            $table->tinyInteger('ismshow', false)->nullable(0)->comment();
            $table->tinyInteger('ismember', false)->nullable(0)->comment();
            $table->tinyInteger('issearch', false)->nullable(0)->comment();
            $table->tinyInteger('vieworder', false)->nullable(0)->comment();
            $table->tinyInteger('disabled', false)->nullable(0)->comment();
            $table->integer('times')->nullable()->comment(lzs_lang('lzscms::public.times'));
            $table->text('setting')->nullable()->comment();
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
        Schema::drop('common_fields');
    }
}
