<?php

namespace Yoeunes\Notify\Notifiers;

use function basename;

abstract class AbstractNotifier
{
    /** @var array */
    protected $config;

    /**
     * Toastr constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Render the notifications' script tag.
     *
     * @param array $notifications
     *
     * @return string
     */
    public function render(array $notifications): string
    {
        return '<script type="text/javascript">'.$this->options().$this->notificationsAsString($notifications).'</script>';
    }

    /**
     * Get global toastr options.
     *
     * @return string
     */
    public function options(): string
    {
        return '';
    }

    /**
     * @param array $notifications
     *
     * @return string
     */
    public function notificationsAsString(array $notifications): string
    {
        return implode('', $this->notifications($notifications));
    }

    /**
     * map over all notifications and create an array of toastrs.
     *
     * @param array $notifications
     *
     * @return array
     */
    public function notifications(array $notifications): array
    {
        return array_map(
            function ($n) {
                return $this->notify($n['type'], $n['message'], $n['title'], $n['options']);
            },
            $notifications
        );
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
    abstract public function notify(string $type, string $message = '', string $title = '', string $options = ''): string;

    /**
     * Get Allowed Types
     *
     * @return array
     */
    public function getAllowedTypes(): array
    {
        return $this->config['types'];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return basename(\get_class($this));
    }
}
