<?php

namespace App\Helpers;

class BrowserHelper
{
    public static function name($userAgent)
    {
        if (str_contains($userAgent, 'Edg')) {
            return 'Microsoft Edge';
        }

        if (str_contains($userAgent, 'Chrome')) {
            return 'Google Chrome';
        }

        if (str_contains($userAgent, 'Firefox')) {
            return 'Mozilla Firefox';
        }

        if (str_contains($userAgent, 'Safari')) {
            return 'Safari';
        }

        return 'Otro';
    }
}