<?php

namespace Gengxuliang\LaravelSms\Channels;

use Gengxuliang\LaravelSms\Models\SmsLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Notification;
use Leonis\Notifications\EasySms\Exceptions\CouldNotSendNotification;
use Overtrue\EasySms\Messenger;

class EasySmsChannel
{
    /**
     * Send the given notification.
     *
     * @param              $notifiable
     * @param Notification $notification
     */
    public function send($notifiable, Notification $notification)
    {
        if ($notifiable instanceof Model) {
            $to = $notifiable->routeNotificationForEasySms($notification);
        }

        $message = $notification->toEasySms($notifiable);
        $rs      = app()->make('easysms')->send($to, $message);
        foreach ($rs as $k => $v) {
            if ($v['status'] == Messenger::STATUS_SUCCESS) {
                $log            = $notification->toArray($notifiable);
                $log['gateway'] = $v['gateway'];
                SmsLog::create($log);
                break;
            }
        }
    }
}
