<?php

namespace App\Http\Controllers;

use App\Models\accounts\DebitAccount;
use App\Models\accounts\InvestmentAccount;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InvestmentAccountController extends Controller
{
    private function createInvestAccountNr(): string
    {
        $num = "ICODE";
        for ($i = 0; $i < 10; $i++) {
            $num .= rand(0, 9);
        }
        return $num;
    }

    public function index(User $user)
    {
        return view('accounts.invest',
            [
                'investAccount' => $user->investmentAccount,
                'user' => $user
            ]);
    }

    public function create(User $user): View
    {
        return view('accounts.create', ['user' => $user]);
    }

    public function store(Request $request, User $user): RedirectResponse
    {
        $investAccount = (new InvestmentAccount())->fill([
            'account_number' => $this->createInvestAccountNr(),
            'currency' => $user->currency,
            'currency_amount' => 0
        ]);
        $investAccount->user()->associate($user);
        $investAccount->save();

        return redirect()->route('home.show', ['home' => $user->id]);
    }

    public function show($id)
    {

    }

    public function update(Request $request, User  $user)
    {

        $investAcc= $user->investmentAccount()->get();
        $debitAcc=$user->debitAccount()->get();
        $deposit = $request->get('investmentAccountDeposit');
        if ($deposit !== null) {
            $investAcc[0]->deposit($deposit);
            $investAcc[0]->update();
            $debitAcc[0]->withdraw($deposit);
            $debitAcc[0]->update();
        }
    }


}
