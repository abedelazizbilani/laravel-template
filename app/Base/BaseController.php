<?php



namespace App\Base;

use App\Http\Response\Response;
use App\Jobs\SendPush;
use App\Models\Device;
use App\Models\UserNotifications;
use App\Traits\ExceptionTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * Http Controller Base class
 */
Abstract class BaseController extends Controller
{
    use ExceptionTrait, AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /*
     * Response
     */
    protected $response;

    /*
     * request
     */
    protected $request;

    /*
     * action
     */
    protected $action;

    /*
     * user
     */
    protected $user;

    public function __construct(Request $request)
    {
        $this->request  = $request;
        $this->response = new Response();

        $this->user = \Auth::user();

        $this->init();
    }

      protected function init()
    {
        return true;
    }

    public function in($key, $default = null)
    {
        return $this->request->input($key, $default);
    }

    public function success($message = null, $data = null)
    {
        return $this->response->success($message, $data);
    }

    public function successData($data = null)
    {
        return $this->response->success(Response::STATUS_SUCCESS, $data);
    }

    public function failed($message = null, $data = null)
    {
        $message = $message ?: Response::STATUS_FAILED;

        return $this->response->failed($message, $data);
    }

    public function failedData($data = null)
    {
        return $this->response->failed(Response::STATUS_FAILED, $data);
    }


    public function sendPush($body, $to = false, $parameters = [], $extraData = [])
    {
        if ($to) {
            //get all user's devices
            $devices = Device::where("user_id", $to)->get();
            if (empty($devices)) {
                \Log::error('Failed Push Notification To user: [' . $to . ']');

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


    /**
     * @param $from
     * @param $comment
     *
     * @return array
     */
    protected function notifyUser($to, $from, $message, $type = null, $parameters = null)
    {
        $notification            = new UserNotifications();
        $notification->user_id   = $from->id;
        $notification->target_id = $to->id;
        $notification->type      = $type;
        $notification->desc      = $message;
        $notification->save();

        $this->sendPush($message, $to->id, $parameters);

        return array($notification, $message);
    }
}