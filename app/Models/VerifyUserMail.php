<?php

namespace App\Notifications\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class VerifyUserMail extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var array
     */
    public $data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data = null)
    {
        $this->data = $data;
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
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        $plainPassword = $this->data['plainPassword'];
        return (new MailMessage)
            ->greeting(new HtmlString("<span class='text_title ml-0'>Kính gửi</span>: $notifiable->name,"))
            ->subject('Thông tin xác thực tài khoản')
            ->line(new HtmlString("Bạn đăng nhập bằng tài khoản mạng xã hội."))
            ->line("Tài khoản: $notifiable->email")
            ->line("Mật khẩu: $plainPassword")
            ->line('Vui lòng đổi mật khẩu ngay sau khi đăng nhập để đảm bảo an toàn thông tin tài khoản!')
            ->action('Xác nhận tài khoản', $this->getRedirectURL($notifiable));
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

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function getRedirectURL($notifiable): string
    {
        return getWebURL('');
    }
}
