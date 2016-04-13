<?php namespace App\Services;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Mail\Mailer as IlluminateMailer;
use Illuminate\Mail\Message;

class Mailer
{
    /**
     * @var IlluminateMailer
     */
    private $mailer;

    /**
     * @var string
     */
    protected $from = 'noreply@cloudhorizon.com';

    /**
     * @var string
     */
    protected $fromName = 'Cloud Horizon';

    /**
     * @var string
     */
    protected $to;

    /**
     * @var string
     */
    protected $subject = 'Cloud Horizon';

    /**
     * @var string
     */
    protected $view;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * Mailer constructor.
     *
     * @param IlluminateMailer $mailer
     */
    public function __construct(IlluminateMailer $mailer)
    {
        $this->mailer = $mailer;
        $this->from   = env('MAIL_FROM', 'noreply@cludhorizon.com');
    }

    /**
     * @param User   $user
     * @param string $view
     */
    public function sendActivationEmail(User $user, $view = 'auth.emails.confirm')
    {
        $this->to   = $user->email;
        $this->view = $view;
        $this->data = [
            'token' => $user->getToken()
        ];

        $this->deliver();
    }

    /**
     * Send email
     *
     * @param UploadedFile|null $attachment
     */
    protected function deliver(UploadedFile $attachment = null)
    {
        $this->data['subject'] = $this->subject;
        $this->mailer->send($this->view, $this->data, function (Message $msg) use($attachment) {
            $msg->from($this->from, $this->fromName)
                ->to($this->to)
                ->subject($this->subject);

            if ($attachment !== null) {
                $msg->attach($attachment->getPathname(), [
                    'as'   => $attachment->getClientOriginalName(),
                    'mime' => $attachment->getMimeType()
                ]);
            }
        });
    }

}