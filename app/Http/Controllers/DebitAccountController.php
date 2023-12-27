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
use Illuminate\View\View;

class DebitAccountController extends Controller
{
    private function createDebitAccountNr(): string
    {
        $num = "DCODE";
        for ($i = 0; $i < 10; $i++) {
            $num .= rand(0, 9);
        }
        return $num;
    }

    public function index(): View
    {
        return view('accounts.debit', ['user' => Auth::user()]);
    }


    public function create(User $user): View
    {
        return view('accounts.create', ['user' => $user]);
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

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $deposit = $request->get('debitAccountDeposit');
        if ($deposit !== null) {
            DepositOnDebitAccount::make($user, $deposit);
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
        }
        return redirect(route('home.show', ['home' => $user]));
    }

    public function destroy($id)
    {
        //
    }
}
