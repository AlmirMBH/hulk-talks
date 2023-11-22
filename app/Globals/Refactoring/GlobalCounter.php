<?php

declare(strict_types=1);

namespace App\Globals\Refactoring;

class GlobalCounter
{
    private static int $countLoggedUsers = 0;

    public static int $countLoggedGuests = 0;

    /**
     * Scope limited
     * access controlled,
     * one place to change,
     * one place to debug,
     * one user count no matter what the method argument is,
     * only integers greater than 0 allowed
     */
    public static function incrementUserCount($addOneToCount): void // deliberately not type-hinting the argument
    {
        if (filter_var($addOneToCount, FILTER_VALIDATE_INT) && ($addOneToCount > 0)) {
            self::$countLoggedUsers++;
        }
    }

    public static function getUserCount(): int
    {
        return self::$countLoggedUsers;
    }
}
