<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewCareers extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $email, $phone, $job_title, $cv)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->job_title = $job_title;
        $this->cv = $cv;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->email, 'The Grand Venice Mall')
                ->replyTo($this->email, $this->name)
                ->view('careersmail')
                ->subject("Career Request")
                ->with(['name' => $this->name, 'email' => $this->email,
                    'phone' => $this->phone,'job_title' => $this->job_title,'cv' => $this->cv]);
    }
}
