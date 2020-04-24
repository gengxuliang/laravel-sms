# Laravel发短信扩展

使用 [overtrue/easy-sms](https://github.com/overtrue/easy-sms) 发送 Laravel 消息通知，并记录日志。

## 安装

```shell
$ composer require gengxuliang/laravel-sms
```

## 配置

1. 在 config/app.php 注册 ServiceProvider (Laravel 5.5 + 无需手动注册)：

    ```php
    'providers' => [
        Gengxuliang\LaravelSms\LaravelSmsServiceProvider::class,
    ],
    ```

2. 创建配置文件：

    ```shell
    $ php artisan vendor:publish --provider="Gengxuliang\LaravelSms\LaravelSmsServiceProvider"
    ```
    
3. 修改应用根目录下的 config/easysms.php 中对应的参数即可。

## 使用

1. 创建通知：

    ```shell
    $ php artisan make:notification  SmsCodeNotification
    ```
   
    ```php
    <?php
    
    namespace App\Notifications;
    
    use Illuminate\Bus\Queueable;
    use Illuminate\Notifications\Notification;
    use Gengxuliang\LaravelSms\Channels\EasySmsChannel;
    use Gengxuliang\LaravelSms\Messages\EasySmsMessage;
    
    class SmsCodeNotification extends Notification
    {
        use Queueable;
    
        /**
         * Get the notification's delivery channels.
         *
         * @param mixed $notifiable
         * @return array
         */
        public function via($notifiable)
        {
            return [EasySmsChannel::class];
        }
    
    
        /**
         * 发送短信验证码
         * @param $notifiable
         * @return mixed
         */
        public function toEasySms($notifiable)
        {
            return (new EasySmsMessage)
                ->setContent('模版消息传空就可以')
                ->setTemplate('SMS_164266880')
                ->setData(['code' => 3796]);
        }
    
        /**
         * 记录到数据库
         * @param $notifiable
         * @return array
         */
        public function toArray($notifiable)
        {
            return [
                'mobile'   => $notifiable->mobile,
                'content'  => 3796,
                'type'     => 'code',
                'template' => 'SMS_164266880',
            ];
        }
    
    }

    ```
    
2. 向已绑定手机号用户发送通知。
    
    用户模型：
    ```php
    <?php
    
    namespace App;
    
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;
    
    class User extends Authenticatable
    {
        use Notifiable;
    
        /**
         * 获取手机号
         * @param $notification
         * @return mixed
         */
        public function routeNotificationForEasySms($notification)
        {
            return $this->mobile;
        }
    }

    ```
    
    发送通知：
    
    ```php
    // 使用 Notifiable Trait
    $user->notify(new SmsCodeNotification());
    // 使用 Notification Facade
    Notification::send($user, new SmsCodeNotification());
    ```

3. 向未注册用户或未绑定手机号用户发送通知。
    
    ```php
   $user = new User();
   $user->mobile = '13123456789';
   $user->notify(new SmsCodeNotification());
    ```

## License

[MIT](https://github.com/gengxuliang/laravel-sms.git)
