<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManageOperationLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manage_operation_log', function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->string('uid')->nullable()->comment('UID');
            $table->string('username')->nullable()->comment(lzs_lang('lzscms::public.username'));
            $table->integer('times')->nullable()->comment(lzs_lang('lzscms::public.times'));
            $table->tinyInteger('status', false)->default(0)->nullable()->comment(lzs_lang('lzscms::public.review.status'));
            $table->string('suid')->nullable()->comment(lzs_lang('lzscms::public.review.uid'));
            $table->string('susername')->nullable()->comment(lzs_lang('lzscms::public.review.username'));
            $table->integer('stimes')->nullable()->comment(lzs_lang('lzscms::public.review.times'));
            $table->ipAddress('ip')->nullable()->comment('IP');
            $table->string('port', 10)->nullable()->comment('IP'.lzs_lang('lzscms::public.port'));
            $table->string('platform')->nullable()->comment(lzs_lang('lzscms::public.operating.system'));
            $table->string('browser')->nullable()->comment(lzs_lang('lzscms::public.browser'));
            $table->text('olddata')->nullable()->comment(lzs_lang('lzscms::public.olddata'));
            $table->text('newdata')->nullable()->comment(lzs_lang('lzscms::public.newdata'));
            $table->text('change')->nullable()->comment(lzs_lang('lzscms::public.change'));
            $table->text('remark')->nullable()->comment(lzs_lang('lzscms::public.remark'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('manage_operation_log');
    }
}
