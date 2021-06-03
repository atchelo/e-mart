<?php

namespace Yoeunes\Notify\Notifiers;

class Pnotify extends AbstractNotifier implements NotifierInterface
{
    /**
     * Get global toastr options.
     *
     * @return string
     */
    public function options(): string
    {
        return 'PNotify.defaults = '.json_encode($this->config['options']).';';
    }

    /**
     * Create a single notification.
     *
     * @param string $type
     * @param string $message
     * @param string|null $title
     * @param string|null $options
     *
     * @return string
     */
    public function notify(string $type, string $message = '', string $title = '', string $options = ''): string
    {
        $options = substr($options, 1, -1);

        if (empty($options)) {
            return "new PNotify({title:'$title', text:'$message', type:'$type'});";
        }

        return "new PNotify({title:'$title', text:'$message', type:'$type', $options});";
    }
}
