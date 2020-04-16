<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManageLoginLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('manage_login_log', function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->string('uid')->nullable()->comment('UID');
            $table->string('username')->nullable()->comment(lzs_lang('lzscms::public.username'));
            $table->integer('times')->nullable()->comment(lzs_lang('lzscms::public.times'));
            $table->text('remark')->nullable()->comment(lzs_lang('lzscms::public.remark'));
            $table->ipAddress('ip')->nullable()->comment('IP');
            $table->string('port', 10)->nullable()->comment('IP'.lzs_lang('lzscms::public.port'));
            $table->string('platform')->nullable()->comment(lzs_lang('lzscms::public.username'));
            $table->string('browser')->nullable()->comment(lzs_lang('lzscms::public.username'));
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
        Schema::drop('manage_login_log');
    }
}
