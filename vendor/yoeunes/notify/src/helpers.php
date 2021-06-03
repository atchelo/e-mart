<?php

use Yoeunes\Notify\Notify;

if (! function_exists('notify')) {
    /**
     * @param string $message
     * @param string $type
     * @param string $title
     * @param array  $options
     *
     * @return Notify
     */
    function notify(string $message = null, string $type = 'success', string $title = '', array $options = []): Notify
    {
        if (is_null($message)) {
            return app('notify');
        }

        return app('notify')->addNotification($type, $message, $title, $options);
    }
}

if (! function_exists('notify_js')) {
    /**
     * @return string
     */
    function notify_js(): string
    {
        $driver  = config('notify.default');
        $scripts = config('notify.'.$driver.'.notify_js');

        return '<script type="text/javascript" src="'.implode('"></script><script type="text/javascript" src="', $scripts).'"></script>';
    }
}

if (! function_exists('notify_css')) {
    /**
     * @return string
     */
    function notify_css(): string
    {
        $driver  = config('notify.default');
        $styles = config('notify.'.$driver.'.notify_css');

        return '<link rel="stylesheet" type="text/css" href="'.implode('"><link rel="stylesheet" type="text/css" href="', $styles).'">';
    }
}
