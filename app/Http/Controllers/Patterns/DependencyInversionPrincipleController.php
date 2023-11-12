<?php

namespace App\Http\Controllers\Patterns;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DependencyInversionPrincipleController extends Controller
{
    //
}

// Dependency Inversion Principle: High-level modules should not depend on low-level modules.
// Both should depend on abstractions.

// Corrected Example applying DIP:
interface Switchable
{
    public function turnOn();
}

class FirstFloorRoom implements Switchable
{
    public function __construct(private string $roomName)
    {
    }

    public function turnOn()
    {
        echo "The light in the {$this->roomName} on the first floor is now on.";
    }
}

class SecondFloorRoom implements Switchable
{
    public function __construct(private string $roomName)
    {
    }

    public function turnOn()
    {
        echo "The light in the {$this->roomName} on the second floor is now on.";
    }
}

    // High-level module LightSwitcher does not depend on the low-level modules FirstFloorRoom and SecondFloorRoom,
    // but on the abstraction/interface Switchable
class LightSwitcher {
    public function __construct(private Switchable $room)
    {
    }

    // IMPORTANT: This would break the DIP because the high-level module would depend on the low-level module Room,
    // that is, the LightSwitcher class would be able to accept only one type of argument - Room.

    //   public function __construct(private Room $room)
    //    {
    //    }

        public function operate()
        {
            $this->room->turnOn();
        }
}

// Usage
$firstFloorLivingRoom = new FirstFloorRoom("Living Room");
$switch = new LightSwitcher($firstFloorLivingRoom);
$switch->operate();

$firstFloorKitchen = new FirstFloorRoom("Kitchen");
$switch = new LightSwitcher($firstFloorKitchen);
$switch->operate();


$secondFloorLivingRoom = new SecondFloorRoom("Living Room");
$switch = new LightSwitcher($secondFloorLivingRoom);
$switch->operate();

$secondFloorKitchen = new SecondFloorRoom("Kitchen");
$switch = new LightSwitcher($secondFloorKitchen);
$switch->operate();


