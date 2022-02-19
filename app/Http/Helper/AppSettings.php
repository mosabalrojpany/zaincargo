<?php
namespace App\Http\Helper;

use App\Models\Setting;

/**
 *  Settings of application
 */
class AppSettings
{

    /**
     * The instance(object) of Settings.
     *
     * @var static
     */
    protected static $instance;

    /**
     * The instance(object) of Settings.
     *
     * @var App\Models\Setting
     */
    protected $settings;

    public function __construct()
    {
        $this->settings = Setting::first();
    }

    /**
     * Get settings
     *
     * @return App\Models\Setting
     */
    public function settings()
    {
        return $this->settings;
    }

    /**
     * Get the instance of the current class.
     *
     * @return static
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }

}
