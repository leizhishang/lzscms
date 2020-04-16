<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('sms_logs', function (Blueprint $table) 
        {
            $table->increments('id')->comment('ID');
            $table->string('type', 30)->default('')->comment(lzs_lang('lzscms::public.type'));
            $table->integer('times')->nullable()->comment(lzs_lang('lzscms::public.times'));
            $table->integer('uid')->nullable()->comment('UID');
            $table->string('note', 255)->default('')->comment(lzs_lang('lzscms::public.note'));
            $table->string('code', 255)->default('')->comment(lzs_lang('lzscms::public.code'));
            $table->string('sendnum', 255)->default('')->comment(lzs_lang('lzscms::public.num'));
            $table->text('content', 255)->comment(lzs_lang('lzscms::public.content'));
            $table->text('mobile', 255)->comment(lzs_lang('lzscms::public.mobile'));
            $table->tinyInteger('status', false)->default(1)->comment(lzs_lang('lzscms::public.status'));
            $table->string('rtype', 255)->default('')->comment();
            $table->string('requestid', 255)->default('')->comment();
            $table->integer('jstimes')->nullable()->comment();
            $table->integer('stimes')->nullable()->comment();
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
        Schema::drop('sms_logs');
    }
}
