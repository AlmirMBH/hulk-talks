<?php

namespace App\Http\Controllers\Refactoring;

use App\Http\Controllers\Controller;
use App\Models\Refactoring\AccountBalance;
use ReflectionClass;

/**
 * MUTABLE DATA
 */
class MutableDataController extends Controller
{
    /**
     * ENCAPSULATION VIOLATED (ACCESSING PROPERTY DIRECTLY)
     * Once you have a setter, it’s easy to start using it everywhere, you can no longer guarantee that the object is
     * in a valid state. You can’t tell whether the object is valid just by looking at it—you have to know the history
     * of all the calls that have been made to it.
     */
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


    /**
     * ENCAPSULATION VIOLATED (SETTER)
     * Once you have a setter, it’s easy to start using it everywhere, you can no longer guarantee that the object is
     * in a valid state. You can’t tell whether the object is valid just by looking at it—you have to know the history
     * of all the calls that have been made to it.
     */
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


    /**
     * ENCAPSULATION NOT VIOLATED (REFLECTION USED TO VIOLATE ENCAPSULATION)
     * Once set, the value of the property cannot be changed. This is a good way to prevent the property from being
     * changed, but it does not prevent the object from being changed.
     */
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


    /**
     * ENCAPSULATION NOT VIOLATED (READONLY PROPERTY)
     * Once set with readonly modifier, neither value of the property nor object can be changed.
     */
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
