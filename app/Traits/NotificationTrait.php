<?php
/**
 * Created by PhpStorm.
 * User: Ideatolife
 * Date: 7/5/2017
 * Time: 6:28 PM
 */

namespace App\Traits;


use App\Jobs\SendPush;
use App\Models\Device;
use App\Models\UserNotifications;

trait NotificationTrait
{
    /**
     * @param $to
     * @param $message
     * @param $type
     *
     * @return array
     * Description: The following function send notification to Users
     */
    public function sendNotification($to, $message, $type, $group = false)
    {
        $notification          = new UserNotifications();
        $notification->user_id = 1;
        if ( ! $group) {
            $notification->target_id = $to;
        }
        $notification->desc = $message;
        $notification->type = $type;
        $notification->save();

        if ( ! $group) {
            $this->sendPush($message, $to);
        } else {
            $data['message'] = $message;
            $data['message'] = $group;
            dispatch(new SendPush($data));
        }

        return array($notification);
    }

    public function sendPush($body, $to = false, $parameters = [], $extraData = [])
    {
        if ($to) {
            //get all user's devices
            $devices = Device::where("user_id", $to)->get();
            if (empty($devices)) {
                \Log::error('Failed Push Notification To user: ['.$to.']');

                return false;
            }
        } else {
            //get current user
            $devices = [app("DeviceInfo")];
        }

        //collect all devices and add them to the token array
        $data = ['body' => $body];
        foreach ($devices AS $device) {
            //if no device type or locale , then ignore the device and continue
            if (empty($device->locale) || empty($device->token)) {
                continue;
            }
            $data['tokens'][$device->locale][] = $device->token;
        }

        //if not devices then return true
        if (empty($data['tokens'])) {
            return true;
        }

        \Log::debug('Checking $extraData data:', [$extraData]);
        $data['parameters'] = $parameters;
        $data['extraData']  = $extraData;
        dispatch(new SendPush($data));
    }
}