<?php

namespace App\Traits;
use Illuminate\Support\Facades\Config;

trait HasMailSettings
{
   protected function bootstrapMailConfig(): void
    {
        Config::set('mail.default', setting('mail.mailer') ?: config('mail.default'));

        Config::set('mail.mailers.smtp', [
            'transport'  => 'smtp',
            'host'       => setting('mail.host')       ?: config('mail.mailers.smtp.host'),
            'port'       => setting('mail.port')       ?: config('mail.mailers.smtp.port'),
            'encryption' => setting('mail.encryption') ?: config('mail.mailers.smtp.encryption'),
            'username'   => setting('mail.username')   ?: config('mail.mailers.smtp.username'),
            'password'   => setting('mail.password')   ?: config('mail.mailers.smtp.password'),
            'timeout'    => null,
        ]);

        Config::set('mail.from', [
            'address' => setting('mail.from_address') ?: config('mail.from.address'),
            'name'    => setting('mail.from_name')    ?: config('mail.from.name'),
        ]);

        app()->forgetInstance('mail.manager');
        app()->forgetInstance('mailer');
    }
}
