<?php



namespace App\Base;

use Illuminate\Database\Eloquent\Model;

/**
 * Eloquent Model Base class
 */
Abstract class BaseModel extends Model
{
    public $hideTimestamp = true;

    /**
     * Create a new Eloquent model instance.
     *
     * @param  array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * Hides attributes of the Eloquent model instance.
     *
     * @param array $attrs
     */
    public function hideAttributes(array $attrs)
    {
        foreach ($attrs as $attr) {
            $this->hidden[] = $attr;
        }
    }

    /**
     * Get the hidden attributes for the model.
     *
     * @return array
     */
    public function getHidden()
    {
        if ($this->hideTimestamp) {
            return array_merge($this->hidden, ['created_at', 'updated_at']);
        }

        return $this->hidden;
    }
}