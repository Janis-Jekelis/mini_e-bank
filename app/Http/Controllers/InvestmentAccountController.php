<?php

namespace App\Http\Controllers;

use App\Api\CurrencyRates;
use App\Models\accounts\DebitAccount;
use App\Models\accounts\InvestmentAccount;
use App\Models\User;
use App\Rules\Amount;
use App\Transfers\BuyAsset;
use App\Transfers\DepositOnInvestAccount;
use Exception;
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

    public function index()
    {
        $user=Auth::user();
        return view('accounts.invest',
            [
                'user' => $user,
                'assets' => CurrencyRates::getAssets($user->currency),
                'ownedAssets'=>$user->investmentAccount()->get()->first()
                ->asset()->get()
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

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if ($request->get('investAccountDeposit') !== null) {
            $debitAccFunds = $user->debitAccount()->get()->first()->amount;
            $request->validate([
                'investAccountDeposit' => ['gt:0', new Amount($debitAccFunds)]
            ]);
            (new DepositOnInvestAccount($user, $request->get('investAccountDeposit')))->make();
        }
        if ($request->get('assetName') !== null) {
            $asset = new BuyAsset($user, $request->get('assetName'), $request->get('assetAmount'));
            $investAccFunds = $user->investmentAccount()->get()->first()->currency_amount;
            $request->validate([
                'assetAmount' => ['gt:0', new Amount($investAccFunds,$asset->getRate())]
            ]);
            $asset->buy();
        }
        return redirect(route('invest.index', ['user' => $user]));
    }


}
