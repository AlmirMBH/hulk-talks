<?php

namespace App\Http\Controllers\Patterns;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SingleResponsibilityPrincipleController extends Controller
{
    //
}


// Single Responsibility Principle (SRP): A class should have only one reason to change,
// meaning it should have only one responsibility.

class Logger
{
    public function logMessage(string $message)
    {
        // Simplified logging logic
        echo "Logging: $message\n";
    }
}

class DataProcessor
{
    private Logger $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function processData(array $data)
    {
        // Process data (simplified logic)
        $this->logger->logMessage("Data processed: " . json_encode($data));
    }
}

// Usage
$logger = new Logger();
$dataProcessor = new DataProcessor($logger);

$data = ['item1', 'item2', 'item3'];
$dataProcessor->processData($data);
