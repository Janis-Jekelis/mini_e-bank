<?php

namespace App\Http\Controllers;

use App\Models\accounts\DebitAccount;
use App\Models\User;
use App\Rules\Amount;
use App\Transfers\DepositOnDebitAccount;
use App\Transfers\Transfer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DebitAccountController extends Controller
{
    public function index(): View
    {
        return view('accounts.debit', ['user' => Auth::user()]);
    }

    public function store(User $user): RedirectResponse
    {
        $debitAccount = (new DebitAccount())->fill([
            'account_number' => $this->createDebitAccountNr(),
            'currency' => $user->currency,
            'amount' => 0
        ]);
        $debitAccount->user()->associate($user);
        $debitAccount->save();
        return redirect()->route('home.show', ['home' => $user->id]);
    }

    public function update(Request $request): RedirectResponse
    {
        $message = '';
        $user = Auth::user();
        $deposit = $request->get('debitAccountDeposit');
        if ($deposit !== null) {
            $request->validate([
                'debitAccountDeposit' => 'gt:0'
            ]);
            DepositOnDebitAccount::make($user, $deposit);
            $message = 'deposit successful';
        }

        if ($request->get('withdraw') !== null) {
            $amount = $request->get('withdraw');
            $debitAcc = $user->debitAccount()->get()->first();
            $request->validate([
                'withdraw' => ['gt:0', new Amount($debitAcc->amount)]
            ]);
            $debitAcc->withdraw($amount);
            $debitAcc->update();
            $message = 'Withdraw successful';
        }

        if ($request->get('transferToAccount') !== null || $request->get('transfer') !== null) {
            $debitAccFunds = $user->debitAccount()->get()->first()->amount;
            $request->validate([
                'transferToAccount' => 'required|exists:debit_accounts,account_number',
                'transfer' => [
                    'required',
                    new Amount($debitAccFunds),
                    'gt:0'
                ]
            ]);
            (new Transfer($user, $request->get('transferToAccount'), $request->get('transfer')))->make();
            $message = 'Transfer successful';
        }
        return redirect(route('debit.index', ['user' => $user]))->with('message', $message);
    }

    public function destroy(User $user)
    {
        $debitAccount = $user->debitAccount()->get()->first();
        $investmentAccount = $user->investmentAccount()->get()->first();
        if (($debitAccount->amount) !== 0 || $investmentAccount !== null) {
            return redirect()->route('debit.index', ['user' => $user])->withErrors([
                'errors' => 'Before closing account make sure investment account is closed' .
                    'and there are no funds on accounts'
            ]);
        }
        $debitAccount->delete();
        return redirect()->route('home.show', ['home' => $user->id])->with('message', 'Debit account closed');
    }

    private function createDebitAccountNr(): string
    {
        $num = "DCODE";
        do {
            for ($i = 0; $i < 10; $i++) {
                $num .= rand(0, 9);
            }
        } while ($this->accountNumberExists($num));

        return $num;
    }

    private function accountNumberExists(string $accountNumber): bool
    {
        return DB::table('debit_accounts')
            ->where('account_number', "$accountNumber")
            ->exists();
    }
}
