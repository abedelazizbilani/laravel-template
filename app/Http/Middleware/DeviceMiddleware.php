<?php



namespace App\Http\Middleware;

use App\Models\Device;
use App\Models\PushNotificationTopic;
use App\Traits\ExceptionTrait;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class DeviceMiddleware
{
    use ExceptionTrait;
    public $request;

    /**
     * Description: The following method is used to handle the incoming request for the current middleware
     *
     * @author
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    public function handle(Request $request, Closure $next)
    {
        $device        = false;
        $this->request = $request;
        $deviceId      = $request->headers->get('x-device-id');
        $uuid          = $request->headers->get('x-device-uuid');

        if ($deviceId) {

            $device = Device::find($deviceId);
            if (!$device) {
                $this->raiseAuthorizationException('refresh_your_device_id');
            }
            if ($device->active != 1) {
                $this->raiseAuthorizationException('user_blocked');
            }
            $this->updateDevice($device);
        } elseif ($uuid) {
            // new device
            $device = $this->findDeviceByUUID($uuid);
            if (!$device) {
                $device = $this->createDevice();
            }
        }

        if (!$device) {
            $this->raiseAuthorizationException('no_device_id_found');
        }

        //set device info singleton
        app()->instance('DeviceInfo', $device);
        app('translator')->setLocale($device->locale);

        $response = $next($request);
        $response->headers->set('x-device-id', $device->id);

        return $response;
    }

    /**
     * Description: find Device By UUID
     *
     * @author
     * @return bool|\App\Models\Device
     */
    protected function findDeviceByUUID($uuid)
    {
        $device = Device::where("uuid", $uuid)->first();
        if (!$device) {
            return false;
        }

        if ($device->active != 1) {
            $this->raiseAuthorizationException('user_blocked');
        }

        $data = $this->request->headers->all();
        if (!empty($data['type'][0])) {
            $device->type = strtolower($data['type'][0]);
        }
        if (!empty($data['version'][0])) {
            $device->version = strtolower($data['version'][0]);
        }
        if (!empty($data['locale'][0])) {
            $device->locale = strtolower($data['locale'][0]);
        }

        if ($device->save()) {
            if (!empty($data['x-token'][0])) {
                $this->saveToken($device, $data['x-token'][0]);
            }

            return $device;
        }


        //if not saved , remove it and add new record
        $device->delete();

        return false;
    }

    /**
     * Description: Create a new Device
     *
     * @author
     * @return bool|\App\Models\Device
     */
    protected function createDevice()
    {
        $data            = $this->request->headers->all();
        $device          = new Device();
        $device->type    = !empty($data['type'][0]) ? strtolower($data['type'][0]) : "";
        $device->version = !empty($data['version'][0]) ? $data['version'][0] : "";
        $device->uuid    = $data['x-device-uuid'][0];
        $device->active  = 1;
        $device->locale  = !empty($data['locale'][0]) ? $data['locale'][0] : "en";
        if ($device->save()) {

            if (!empty($data['x-token'][0])) {
                $this->saveToken($device, $data['x-token'][0]);
            }

            return $device;
        }

        return false;
    }

    /**
     * Description: Update a new Device
     *
     * @author
     *
     * @param $device
     *
     * @return bool
     */
    protected function updateDevice($device)
    {
        $data                = $this->request->headers->all();
        $device->version     = !empty($data['version'][0]) ? $data['version'][0] : $device->version;
        $device->locale      = !empty($data['locale'][0]) ? $data['locale'][0] : $device->locale;
        $device->last_access = Carbon::now();
        $device->save();

        if (!empty($data['x-token'][0])) {

            $this->saveToken($device, $data['x-token'][0]);
        }

        return $device;
    }

    /**
     * @return mixed
     */
    public function saveToken($deviceModel, $token)
    {
        //save it to the device table
        $deviceModel->token = $token;
        $deviceModel->save();

        //join the topic "all"
        $this->joinTopic("all", $token);
        if ($deviceModel->type == "ios") {
            $this->joinTopic("ios", $token);
        } elseif ($deviceModel->type == "android") {
            $this->joinTopic("android", $token);
        }
    }

    /**
     * @return mixed
     */
    public function joinTopic($topicName, $token)
    {
        $topic = PushNotificationTopic::byName($topicName)->first();
        if (!$topic) {
            $topic       = new PushNotificationTopic();
            $topic->name = $topicName;
            $topic->code = $topicName; // as it was used for group before
            $topic->save();
        }

        $guzzleClient = new \GuzzleHttp\Client();
        $guzzleClient->post(
            "https://iid.googleapis.com/iid/info/$token/rel/topics/$topicName",
            [
                'headers' => [
                    'Authorization' => sprintf('key=%s', env('FCM_SERVER_KEY')),
                    'Content-Type' => 'application/json'
                ]
            ]
        );

        return true;
    }

}
