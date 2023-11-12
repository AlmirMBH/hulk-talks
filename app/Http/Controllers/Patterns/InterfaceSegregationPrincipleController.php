<?php

namespace App\Http\Controllers\Patterns;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InterfaceSegregationPrincipleController extends Controller
{
    //
}


// Interface Segregation Principle: A class should not be forced to implement interfaces it does not use

// Incorrect Example:
interface Worker
{
    public function work();
    public function eat();
}

class SimpleWorker implements Worker
{
    public function work()
    {
        // Performing work
    }

    public function eat()
    {
        // Eating during work break
    }
}

// Corrected Example applying ISP:
interface Workable
{
    public function work();
}

interface Eatable
{
    public function eat();
}

class SimpleWorker1 implements Workable, Eatable
{
    public function work()
    {
        // Performing work
    }

    public function eat()
    {
        // Eating during work break
    }
}

// Usage
$worker = new SimpleWorker1();
$worker->work();
$worker->eat();
