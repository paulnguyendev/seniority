<?php
namespace Modules\Authen\Emails;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
class SendVerifyEmail extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data;
    public function __construct($data)
    {
        //
        $this->data = $data;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $from = config('obn.mail.from');
        $brand = config('obn.mail.brand');
        $subject = config('obn.mail.subject.verify_user');
        return $this->view('mail.mail_verify')->from( $from , $brand)->subject("[{$brand}] {$subject} ")->with(['data' => $this->data]);
    }
}
