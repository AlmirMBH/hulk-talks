<?php

namespace App\Globals\Refactoring;

class GlobalCounter
{
    private static int $countLoggedUsers = 0; // This is the encapsulated global data; set it via constructor???

    public static function increment(): void
    {
        self::$countLoggedUsers++;
    }

    public static function getCount(): int
    {
        return self::$countLoggedUsers;
    }
}
