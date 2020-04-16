<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsCodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('sms_code', function (Blueprint $table) 
        {
            $table->string('mobile', 30)->default('')->comment(lzs_lang('lzscms::public.mobile'));
            $table->string('type', 30)->default('')->comment(lzs_lang('lzscms::public.type'));
            $table->string('code', 30)->default('')->comment(lzs_lang('lzscms::public.code'));
            $table->string('number', 30)->default('')->comment(lzs_lang('lzscms::public.type'));
            $table->integer('expired_time')->nullable()->comment();
            $table->integer('create_time')->nullable()->comment(lzs_lang('lzscms::public.times'));
            $table->unique(['mobile','type']);
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
        Schema::drop('sms_code');
    }
}
