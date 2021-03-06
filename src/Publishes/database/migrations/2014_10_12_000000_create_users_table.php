<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateUsersTable extends Migration
{

    protected $bindModel='App\Models\User';

    /**
     * Run the migrations.
     *
     * 返回: void
     */
    public function up()
    {
        $model = new $this->bindModel();
        $prefix = $model->getConnection()->getTablePrefix();
        $connection = $model->getConnectionName()?: config('database.default');
        DB::connection($connection)->statement("CREATE TABLE IF NOT EXISTS `".$prefix.$model->getTable()."` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `uname` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '用户名@sometimes|required|alpha_dash|between:6,18|unique:users,uname',
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '密码\$password@sometimes|required|digits_between:6,18',
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '昵称@required',
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '电子邮箱@sometimes|required|email|unique:users,email',
  `mobile_phone` varchar(11) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '手机号码@sometimes|required|mobile_phone|unique:users,mobile_phone',
  `qq` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'QQ号码@sometimes|required|integer|unique:users,qq',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '2' COMMENT '状态:0-注销,1-有效,2-停用\$radio@nullable|in:0,1,2',
  `description` text COLLATE utf8_unicode_ci COMMENT '备注\$textarea',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `users_uname_index` (`uname`) USING BTREE,
  KEY `users_email_index` (`email`) USING BTREE,
  KEY `users_mobile_phone_index` (`mobile_phone`) USING BTREE,
  KEY `users_qq_index` (`qq`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户\$softDeletes,timestamps,notifiable@hasOne:admin|hasMany:logs'");
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        $model = new $this->bindModel();
        $prefix = $model->getConnection()->getTablePrefix();
        $connection = $model->getConnectionName()?: config('database.default');
        DB::connection($connection)->statement('drop table `'.$prefix.$model->getTable().'`;');
    }
}
