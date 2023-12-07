<?php 
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Kutia\Larafirebase\Messages\FirebaseMessage;
use App\Models\User;
class SendPushNotification extends Notification
{
    use Queueable;

    protected $title;
    protected $message;
    protected $fcmTokens;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($title,$message,$route)
    {
        $this->title = $title;
        $this->message = $message;
        $this->route = $route;
        $fcmTokens = User::whereNotNull('device_token')->pluck('device_token')->toArray();
        $this->fcmTokens = $fcmTokens;
        
        //dd($fcmTokens);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['firebase'];
    }

    public function toFirebase($notifiable)
    {
        $route=explode("/",$this->route);
        
        $result=(new FirebaseMessage)
            ->withTitle($this->title)
            ->withBody($this->message)   
            ->withAdditionalData([
                'notification_foreground' =>true,
                'title'=>$this->title,
                'body'=>$this->message,
                'route'=>$route[0],
                'id'=>$route[1]
            ])
            ->withPriority('high')->asNotification($this->fcmTokens);
            
            return $result;
    }
}