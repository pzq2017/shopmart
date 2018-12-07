<?php

namespace App\Notifications;

use App\Models\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EmailActivateEmail extends Notification implements ShouldQueue
{
    use Queueable;

    public $member;
    public $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Member $member, $token)
    {
        $this->member = $member;
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('邮箱激活')
                    ->line('激活邮箱后可用于账号登录、邮箱找回密码、接受订单提醒等.')
                    ->action('点击这里激活邮箱', route('register.activate_email', ['token' => $this->token]))
                    ->line('激活邮箱链接有效期24h!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
