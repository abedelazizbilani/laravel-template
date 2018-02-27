<?php

use Illuminate\Database\Schema\Blueprint;


class AddBasePermissions extends \App\Base\BaseMigration
{

    public function up()
    {
        $this->addingNewRole('admin');
        $this->addingNewRole('external');
        $this->addingNewPermission('dashboard_login', true);
        $this->addingNewPermission('open_dashboard', true);
        $this->addingNewPermission('manage_setting', true);
        $this->addingNewPermission('manage_users', true);
        $this->addingNewPermission('manage_roles', true);
        $this->addingNewPermission('manage_devices', true);
        $this->addingNewPermission('update_profile', true);
    }

    public function down()
    {
        return true;
    }
}
