<?php

namespace App\Http\Controllers\Patterns;

use App\Http\Controllers\Controller;

class MediatorController extends Controller
{

}

interface Mediator
{
    public function notify(Component $sender, string $event);
}

// Component Interface
interface Component
{
    public function doAction();
}

// Concrete Mediator Class
class ConcreteMediator implements Mediator
{
    public function notify(Component $sender, string $event)
    {
        echo "Mediator reacts to event: $event from " . get_class($sender) . ".\n";
    }
}

// Concrete Component Classes
class Component1 implements Component
{
    public function __construct(private Mediator $mediator)
    {
    }

    public function doAction()
    {
        $this->mediator->notify($this, 'A');
    }
}

class Component2 implements Component
{
    public function __construct(private Mediator $mediator)
    {
    }

    public function doAction()
    {
        $this->mediator->notify($this, 'C');
    }
}

// Usage
$mediator = new ConcreteMediator();

$component1 = new Component1($mediator);
$component2 = new Component2($mediator);

$component1->doAction();
$component2->doAction();
