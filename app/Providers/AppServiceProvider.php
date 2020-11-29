<?php

namespace App\Providers;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\MailManager;
use Illuminate\Mail\Transport\MailgunTransport;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('custom.smtp.mailer', function ($app, $parameters) {
            $smtp_host = $parameters['host'];
            $smtp_port = $parameters['port'];
            $smtp_username = $parameters['username'];
            $smtp_password = $parameters['password'];
            $smtp_encryption = $parameters['encryption'];
            $from_email = $parameters['from_email'];
            $from_name = $parameters['from_name'];

            $transport = new \Swift_SmtpTransport($smtp_host, $smtp_port);
            $transport->setUsername($smtp_username);
            $transport->setPassword($smtp_password);
            $transport->setEncryption($smtp_encryption);

            $swiftMailer = new \Swift_Mailer($transport);

            $mailer = new Mailer('custom_smtp', $app->get('view'), $swiftMailer, $app->get('events'));
            $mailer->alwaysFrom($from_email, $from_name);
            $mailer->alwaysReplyTo($from_email, $from_name);

            return $mailer;
        });
        $this->app->bind('custom.mailgun.mailer', function ($app, $parameters) {
            $transport = new MailgunTransport(
                new HttpClient(Arr::add(
                    [],
                    'connect_timeout',
                    60
                )),
                $parameters['secret'],
                $parameters['domain'],
            );

            $swiftMailer = new \Swift_Mailer($transport);

            $mailer = new Mailer('custom_smtp', $app->get('view'), $swiftMailer, $app->get('events'));
            $mailer->alwaysFrom($parameters['from_email'], $parameters['from_name']);
            $mailer->alwaysReplyTo($parameters['from_email'], $parameters['from_name']);

            return $mailer;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
