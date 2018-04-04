<?php



namespace App\Singleton;

class DeviceInfo
{
    public $device;
    protected $values = [];

    public function setDevice($device)
    {
        $this->device = $device;

        return $this;
    }

    public function __get($key)
    {
        if (isset($this->values[$key])) {
            return $this->values[$key];
        }

        return null;
    }

    public function __set($key, $value)
    {
        $this->values[$key] = $value;
    }
}