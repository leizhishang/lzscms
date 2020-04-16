<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManageUserTable extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manage_user', function (Blueprint $table) {
            $table->increments('uid')->comment('ID');
            $table->string('username')->nullable()->comment(lzs_lang('lzscms::public.username'));
            $table->string('name')->nullable()->comment(lzs_lang('lzscms::public.realname'));
            $table->string('email')->nullable()->comment(lzs_lang('lzscms::public.email'));
            $table->string('password')->nullable()->comment(lzs_lang('lzscms::public.password'));
            $table->string('salt', 10)->nullable()->comment(lzs_lang('lzscms::public.salt'));
            $table->tinyInteger('status', false)->nullable(0)->comment(lzs_lang('lzscms::public.user.status'));
            $table->string('avatar')->nullable()->comment(lzs_lang('lzscms::public.avatar'));
            $table->string('mobile', 20)->nullable()->comment(lzs_lang('lzscms::public.mobile'));
            $table->string('qq', 20)->nullable()->comment('QQ');
            $table->string('weixin', 20)->nullable()->comment(lzs_lang('lzscms::public.weixin'));
            $table->string('gid', 10)->nullable(99)->comment(lzs_lang('lzscms::public.manage.user.gid'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('manage_user');
    }
}
