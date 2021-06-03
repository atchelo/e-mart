<?php

namespace Yoeunes\Notify;

use Illuminate\Config\Repository;
use Illuminate\Session\SessionManager;
use function in_array;
use RuntimeException;
use Yoeunes\Notify\Notifiers\NotifierInterface;

/**
 * @method error(string $message, string $title = '', array $options = [])
 * @method info(string $message, string $title = '', array $options = [])
 * @method success(string $message, string $title = '', array $options = [])
 * @method warning(string $message, string $title = '', array $options = [])
 * @method alert(string $message, string $title = '', array $options = [])
 * @method notice(string $message, string $title = '', array $options = [])
 * @method question(string $message, string $title = '', array $options = [])
 */
class Notify
{
    const NOTIFICATIONS_NAMESPACE = 'notify::notifications';

    /**
     * Added notifications.
     *
     * @var array
     */
    protected $notifications = [];

    /**
     * Illuminate Session.
     *
     * @var \Illuminate\Session\SessionManager
     */
    protected $session;

    /**
     * Notification config.
     *
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    /** @var NotifyInterface */
    protected $notifier;

    /**
     * Notification constructor.
     *
     * @param NotifierInterface $notifier
     * @param SessionManager $session
     * @param Repository $config
     */
    public function __construct(NotifierInterface $notifier, SessionManager $session, Repository $config)
    {
        $this->notifier = $notifier;

        $this->session = $session;

        $this->config = $config;

        $this->notifications = $this->session->get(self::NOTIFICATIONS_NAMESPACE, []);
    }

    /**
     * Add a notification.
     *
     * @param string $type    Could be error, info, success, or warning.
     * @param string $message The notification's message
     * @param string $title   The notification's title
     * @param array $options
     *
     * @return self
     */
    public function addNotification(string $type, string $message, string $title = '', array $options = []): self
    {
        if (!in_array($type, $this->notifier->getAllowedTypes(), true)) {
            throw new RuntimeException('Invalid type "'.$type.'" for the "'.$this->notifier->getName().'"');
        }

        $this->notifications[] = [
            'type'    => $type,
            'title'   => $this->escapeSingleQuote($title),
            'message' => $this->escapeSingleQuote($message),
            'options' => json_encode($options),
        ];

        $this->session->flash(self::NOTIFICATIONS_NAMESPACE, $this->notifications);

        return $this;
    }

    /**
     * helper function to escape single quote for example for french words.
     *
     * @param string $value
     *
     * @return string
     */
    private function escapeSingleQuote(string $value): string
    {
        return str_replace("'", "\\'", $value);
    }

    /**
     * Render the notifications' script tag.
     *
     * @return string
     */
    public function render(): string
    {
        $notification = $this->notifier->render($this->notifications);

        $this->session->forget(self::NOTIFICATIONS_NAMESPACE);

        return $notification;
    }

    /**
     * Clear all notifications.
     *
     * @return self
     */
    public function clear(): self
    {
        $this->notifications = [];

        $this->session->forget(self::NOTIFICATIONS_NAMESPACE);

        return $this;
    }

    /**
     * @param $method
     * @param $arguments
     */
    public function __call($method, $arguments)
    {
        if (!in_array($method, $this->notifier->getAllowedTypes(), true)) {
            throw new RuntimeException('Invalid type "'.$method.'" for the "'.$this->notifier->getName().'"');
        }

        $this->addNotification($method, ...$arguments);
    }
}
