<?php

namespace App\Helpers;

class MailerConfiguration {

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
