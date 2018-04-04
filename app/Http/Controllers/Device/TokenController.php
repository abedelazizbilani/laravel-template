<?php


namespace App\Http\Controllers\Device;

use App\Base\BaseController;
use App\Models\Language;

class TokenController extends BaseController
{
    /**
     * Description: Update device token
     */
    public function update()
    {
        $device        = app("DeviceInfo");
        $device->token = request('deviceToken');
        $device->save();

        return $this->success();
    }

    /**
     * Description: Update device token
     */
    public function changeLanguage()
    {
        $device = app("DeviceInfo");

        $language      = Language::byLocale(request('locale'))->first();
        if(!$language)
        {
            return $this->failed("idea::general.record_does_not_exist");
        }
        $device->locale = $language->locale;
        $device->save();

        return $this->success();
    }
}