<?php

namespace Yoeunes\Notify\Notifiers;

interface NotifierInterface
{
    /**
     * Render the notifications' script tag.
     *
     * @param array $notifications
     *
     * @return string
     */
    public function render(array $notifications): string;

    /**
     * Get Allowed Types
     *
     * @return array
     */
    public function getAllowedTypes(): array;

    /**
     * @return string
     */
    public function getName(): string;
}
