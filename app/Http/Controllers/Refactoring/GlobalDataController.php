<?php

namespace App\Http\Controllers\Refactoring;

use App\Globals\Refactoring\GlobalCounter;
use App\Http\Controllers\Controller;

/**
 * GLOBAL DATA
*/
class GlobalDataController extends Controller
{
    public function getCount($addOneToCount = null): array // all data types allowed for presentation purposes
    {

        // Global data encapsulated
        GlobalCounter::incrementUserCount($addOneToCount);

        // Global data not encapsulated
        $totalGuestCount = GlobalCounter::$countLoggedGuests + $addOneToCount;



        return [
            'totalUserCount' => GlobalCounter::getUserCount(),
            'totalGuestCount' => $totalGuestCount
        ];
    }
}
