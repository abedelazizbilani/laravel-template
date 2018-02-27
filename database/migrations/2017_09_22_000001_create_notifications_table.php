<?php

use Illuminate\Database\Schema\Blueprint;

class CreateNotificationsTable extends \App\Base\BaseMigration
{

    public function up()
    {
        Schema::create(
            'notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->unique();
            $table->json('keys')->nullable();

            $table->string('title')->translate();
            $table->text('sms_body')->translate();
            $table->text('push_body')->translate();
            $table->text('email_body')->translate();
            $table->timestamps();

            $this->setMainTable($table);
        });

        $this->translateMainTable(true);


        Schema::create(
            'notification_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->text('message');
            $table->string('topic');
            $table->timestamps();
        });

        Schema::table(
            "notification_histories",
            function (Blueprint $table) {
                $table->foreign('user_id')->references('id')->on("users")
                    ->onUpdate('CASCADE')->onDelete('CASCADE');
            }
        );

    }

    public function down()
    {
        Schema::drop('notifications');
        Schema::drop('notification_template');
        Schema::drop('notification_history');
    }
}
