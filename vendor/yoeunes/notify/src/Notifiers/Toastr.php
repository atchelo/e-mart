<?php

namespace Yoeunes\Notify\Notifiers;

class Toastr extends AbstractNotifier implements NotifierInterface
{
    /**
     * Get global toastr options.
     *
     * @return string
     */
    public function options(): string
    {
        return 'toastr.options = '.json_encode($this->config['options']).';';
    }

    /**
     * Create a single notification.
     *
     * @param string      $type
     * @param string      $message
     * @param string|null $title
     * @param string|null $options
     *
     * @return string
     */
    public function notify(string $type, string $message = '', string $title = '', string $options = ''): string
    {
        return "toastr.$type('$message', '$title', $options);";
    }
}
