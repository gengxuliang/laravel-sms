<?php

namespace Gengxuliang\LaravelSms\Channels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Notification;
use Leonis\Notifications\EasySms\Exceptions\CouldNotSendNotification;

class EasySmsChannel
{
    /**
     * Send the given notification.
     *
     * @param $notifiable
     * @param Notification $notification
     */
    public function send($notifiable, Notification $notification)
    {
        if ($notifiable instanceof Model) {
            $to = $notifiable->routeNotificationForEasySms($notification);
        }

        $message = $notification->toEasySms($notifiable);
        app()->make('easysms')->send($to, $message);
    }
}
