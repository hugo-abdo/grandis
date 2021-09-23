<?php

namespace App\Services;

class NotificationsServices
{
    public function read_page_notifications(String $type = null): NotificationsServices
    {
        $notifications = \Auth::user()->unreadNotifications()->where('notifiable_type', $type)->get();
        $notifications->each(fn($n) => $n->markAsRead());
        return $this;
    }
}
