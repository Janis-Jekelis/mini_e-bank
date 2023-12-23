<?php

namespace App\Http\Controllers;

use App\Models\accounts\DebitAccount;
use App\Models\accounts\InvestmentAccount;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        return view('accounts.invest', ['user' => Auth::user()]);
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

    public function update(Request $request, User $user)
    {
        return redirect(route('home.show', ['home' => $user]));
    }


}
