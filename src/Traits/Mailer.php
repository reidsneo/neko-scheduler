<?php

namespace Neko\Scheduler\Traits;
use Neko\Mail\Email;

trait Mailer
{
    /**
     * Get email configuration.
     *
     * @return array
     */
    public function getEmailConfig()
    {
        if (! isset($this->emailTo['subject']) ||
            ! is_string($this->emailTo['subject'])
        ) {
            $this->emailTo['subject'] = 'Cronjob execution';
        }

        if (! isset($this->emailTo['from'])) {
            $this->emailTo['from'] = ['cronjob@server.my' => 'My Email Server'];
        }

        if (! isset($this->emailTo['body']) ||
            ! is_string($this->emailTo['body'])
        ) {
            $this->emailTo['body'] = 'Cronjob output attached';
        }
        return $this->emailTo;
    }

    /**
     * Send files to emails.
     *
     * @param  array  $files
     * @return void
     */
    private function sendToEmails(array $files)
    {
        global $app;
        $config = $this->getEmailConfig();
        if(count($config)>0)
        {            
            $mailer = new Email();
            $mailer->setAdapter($app->config['email']);
            if($config['attach_output']==true){
                $mailer->send($config['from'],$config['to'],$config['subject'],$config['body']);
            }else{
                //fixme
                $mailer->send($config['from'],$config['to'],$config['subject'],$config['body'],$files);
            }
        }
    }
}
