<?php

namespace App\Helpers;

class MailerConfiguration {

    /**
     * The function updates the email configuration settings for a custom mailer in a PHP application.
     * 
     * @param object emailCredentials The `` parameter is an object that contains the
     * following properties:
     */
    public static function update(object $emailCredentials): void {
        $mailerConfig = [
            'transport' => $emailCredentials->mailer,
            'host' => $emailCredentials->host,
            'port' => $emailCredentials->port,
            'encryption' => $emailCredentials->encryption,
            'username' => $emailCredentials->username,
            'password' => $emailCredentials->password,
            'timeout' => null,
        ];

        config(['mail.mailers.custom' => $mailerConfig]);
    }
}
