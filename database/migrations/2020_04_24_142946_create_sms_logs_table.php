<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_logs', function (Blueprint $table) {
            $table->id();
            $table->char('mobile', 11)->comment('用户手机');
            $table->string('content')->nullable()->comment('发送内容');
            $table->string('template', 16)->nullable()->comment('短信模板');
            $table->string('type', 16)->comment('短信类型')->index();
            $table->string('gateway', 16)->comment('短信网关');
            $table->timestamps();
            $table->index(['mobile', 'created_at']);
        });
        \DB::statement("ALTER TABLE `sms_logs` comment '短信日志表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sms_logs');
    }
}
