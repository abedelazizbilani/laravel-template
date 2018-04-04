<?php

use App\Base\BaseMigration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBasicTables extends BaseMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'languages',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('title');
                $table->string('locale', 3);
                $table->timestamps();
            }
        );

        Schema::create(
            'users',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('username', 100)->unique();
                $table->string('password', 60);
                $table->string('email')->nullable();
                $table->string('name')->nullable();
                $table->string('phone')->nullable();
                $table->string('job_type')->nullable();
                $table->boolean('active')->default(false);
                //used to make handle changing password or signing out from other devices
                $table->string('jwt_sign', 100)->nullable();
                // Email verification
                $table->string('email_confirm_code', 100)->nullable();
                $table->dateTime('email_confirm_expiry')->nullable();
                $table->dateTime('email_confirmed_at')->nullable();
                // Forgot password
                $table->string('password_change_code', 100)->nullable();
                $table->dateTime('password_change_expiry')->nullable();
                $table->dateTime('password_changed_at')->nullable();
                $table->unsignedBigInteger('district_id')->nullable();
                $table->softDeletes();
                $table->timestamps();
            }
        );

        Schema::create(
            'devices',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('type', 20);
                $table->string('version')->nullable();
                $table->string('uuid');
                $table->boolean('active')->default(true);
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('locale', 3)->default("en");
                $table->string('token')->nullable();
                $table->timestamp('last_access')->nullable();
                $table->float('latitude', 10, 0)->nullable()->default(0);
                $table->float('longitude', 10, 0)->nullable()->default(0);
                $table->timestamps();
            }
        );

        Schema::create(
            'countries',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('code');

                $table->string('name')->translate();
                $table->timestamps();
                $this->setMainTable($table);
            }
        );
        $this->translateMainTable(true);

        Schema::create(
            'profiles',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('user_id')->unique();
                $table->string('first_name')->nullable();
                $table->string('middle_name')->nullable();
                $table->string('last_name')->nullable();
                $table->string('phone')->nullable();
                $table->string('image')->nullable();
                $table->enum('gender', ['male', 'female'])->nullable();
                $table->date('dob')->nullable();
                $table->integer('country_id')->nullable();
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users')
                    ->onUpdate('cascade')->onDelete('cascade');
            }
        );

        Schema::create(
            'feedbacks',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('user_id');
                $table->string('subject');
                $table->text('body');
                $table->softDeletes();
                $table->timestamps();
            }
        );

        Schema::create(
            'password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('languages');
        Schema::dropIfExists('devices');
        Schema::dropIfExists('feedbacks');
        Schema::dropIfExists('country_translations');
        Schema::dropIfExists('countries');
        Schema::dropIfExists('profiles');
        Schema::dropIfExists('password_resets');
    }
}
