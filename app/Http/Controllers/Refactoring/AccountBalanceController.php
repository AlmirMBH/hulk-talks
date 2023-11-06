<?php

namespace App\Http\Controllers\Refactoring;

use App\Http\Controllers\Controller;
use App\Models\Refactoring\AccountBalance;
use App\Services\Refactoring\AccountBalanceService;
use ReflectionClass;

/**
 * MUTABLE DATA
 * Changes to data can often lead to unexpected consequences and tricky bugs. I can update some data here, not realizing that another part of the software
 * expects something different and now fails—a failure that’s particularly hard to spot if it only happens under rare conditions. For this reason, an entire
 * school of software development—functional programming—is based on the notion that data should never change and that updating a data structure should
 * always return a new copy of the structure with the change, leaving the old data pristine. These kinds of languages, however, are still a relatively small
 * part of programming; many of us work in languages that allow variables to vary. But this does not mean we should ignore the advantages of immutability;
 * there are still many things we can do to limit the risks on unrestricted data updates. You can use Encapsulate Variable (132) to ensure that all updates
 * occur through narrow functions that can be easier to monitor and evolve. If a variable is being updated to store different things, use Split Variable
 * (240) both to keep them separate and avoid the risky update. Try as much as possible to move logic out of code that processes the update by using Slide
 * Statements (223) and Extract Function (106) to separate the side-effect-free code from anything that performs the update. In APIs, use Separate Query
 * from Modifier (306) to ensure callers don’t need to call code that has side effects unless they really need to. We like to use Remove Setting Method (331)
 * as soon as we can—sometimes, just trying to find clients of a setter helps spot opportunities to reduce the scope of a variable. Mutable data that can be
 * calculated elsewhere is particularly pungent. It is not just a rich source of confusion, bugs, and missed dinners at home—it is also unnecessary. We spray
 * it with a concentrated solution of vinegar and Replace Derived Variable with Query (248). Mutable data is not a big problem when it is a variable whose
 * scope is just a couple of lines—but its risk increases as its scope grows. Use Combine Functions into Class (144) or Combine Functions into Transform (149)
 * to limit how much code needs to update a variable. If a variable contains some data with internal structure, it’s usually better to replace the entire
 * structure rather than modify it in place, using Change Reference to Value (252).
 */
class AccountBalanceController extends Controller
{
    public function __construct(private readonly AccountBalanceService $accountBalanceService)
    {
    }

    public function updateBalanceViolateEncapsulation($amount): array
    {
        $accountBalance = new AccountBalance(
            balanceBreakingEncapsulation: 250
        );

        $updatedAccountBalance = $accountBalance->balanceBreakingEncapsulation += $amount;

        return [
            'originalBalance' => $accountBalance->getBreakingEncapsulationBalance(),
            'amountToAddToOriginal' => $amount,
            'updatedBalance' => $updatedAccountBalance
        ];
    }

    public function updateBalanceViolateEncapsulationWithSetter($amount): array
    {
        $accountBalance = new AccountBalance(
            balanceBreakingEncapsulation: 300
        );

        $updatedAccountBalance = $accountBalance->updateBalanceBreakingEncapsulation($amount);

        return [
            'originalBalance' => $accountBalance->getBreakingEncapsulationBalance(),
            'amountToAddToOriginal' => $amount,
            'updatedBalance' => $updatedAccountBalance
        ];
    }

    public function updateBalanceDontViolateEncapsulation($amount): array
    {
        $accountBalance = new AccountBalance(
            balance:350
        );

        $updatedBalance = $accountBalance->updateBalance($amount);

        // Use reflection to hack the value; could private property and final class prevent this?
        $reflectionClass = new ReflectionClass($updatedBalance);
        $balanceProperty = $reflectionClass->getProperty('balance');
        $balanceProperty->setValue($updatedBalance, 10000);

        return [
            'originalBalance' => $accountBalance->getBalance(),
            'amountToAddToOriginal' => $amount,
            'updatedBalance' => $updatedBalance->getBalance(),
            'hackedBalance' => $balanceProperty->getValue($updatedBalance)
        ];
    }

    public function updateReadonlyBalanceDontViolateEncapsulation($amount): array
    {
        $accountReadonlyBalance = new AccountBalance(
            readonlyBalance:350
        );

        $updatedBalance = $accountReadonlyBalance->updateReadonlyBalance($amount);

        // Use reflection to hack the value; could readonly, private property and final class prevent this?
        $reflectionClass = new ReflectionClass($updatedBalance);
        $balanceProperty = $reflectionClass->getProperty('readonlyBalance');
        $balanceProperty->setValue($updatedBalance, 10000);

        return [
            'originalBalance' => $accountReadonlyBalance->getReadonlyBalance(),
            'amountToAddToOriginal' => $amount,
            'updatedBalance' => $updatedBalance->getReadonlyBalance(),
            'hackedBalance' => $balanceProperty->getValue($updatedBalance)
        ];
    }
}
