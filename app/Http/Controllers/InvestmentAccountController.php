<?php

namespace App\Http\Controllers;

use App\Api\CurrencyRates;
use App\Models\accounts\InvestmentAccount;
use App\Models\Asset;
use App\Models\User;
use App\Rules\Amount;
use App\Transfers\BuyAsset;
use App\Transfers\DepositOnInvestAccount;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;


class InvestmentAccountController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $assets = CurrencyRates::getAssets($user->currency);
        $perPage = 40;
        $page = request()->get('page', 1);
        $currentPageItems = array_slice(get_object_vars($assets), ($page - 1) * $perPage, $perPage);
        $assets = new LengthAwarePaginator(
            $currentPageItems,
            count(get_object_vars($assets)),
            $perPage,
            $page,
            ['path' => Paginator::resolveCurrentPath()]
        );
        if ($user->investmentAccount()->get()->first()->asset()) {
            $ownedAssets = $user->investmentAccount()->get()->first()
                ->asset()->get();
        } else {
            $ownedAssets = [];
            dd($user->investmentAccount()->get()->first()->asset);
        }
        return view('accounts.invest',
            [
                'user' => $user,
                'assets' => $assets,
                'ownedAssets' => $ownedAssets
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
        $message='';
        if ($request->get('investAccountDeposit') !== null) {
            $debitAccFunds = $user->debitAccount()->get()->first()->amount;
            $request->validate([
                'investAccountDeposit' => ['gt:0', new Amount($debitAccFunds)]
            ]);
            (new DepositOnInvestAccount($user, $request->get('investAccountDeposit')))->make();
            $message='Deposit successful';
        }
        if ($request->get('assetName') !== null) {
            $assetName=$request->get('assetName');
            $assetAmount=$request->get('assetAmount');
            $asset = new BuyAsset($user, $assetName, $assetAmount);
            $investAccFunds = $user->investmentAccount()->get()->first()->currency_amount;
            $request->validate([
                'assetAmount' => ['gt:0', new Amount($investAccFunds, $asset->getRate())]
            ]);
            $asset->buy();
            $message="purchased $assetAmount units of $assetName";
        }

        if ($request->get('soldAsset') !== null) {
            $asset = Asset::findOrFail($request->get('soldAsset'));
            $request->validate([
                'assetSellAmount' => ['gt:0', "lte:$asset->amount"]
            ]);
            $asset->sell($request->get('assetSellAmount'));
            $message="sold {$request->get('assetSellAmount')} units of $asset->name";
        }

        if ($request->get('withdraw') !== null) {
            $amount = $request->get('withdraw');
            $debitAcc = $user->debitAccount()->get()->first();
            $investAcc = $user->investmentAccount()->get()->first();
            $request->validate([
                'withdraw' => ['gt:0', new Amount($investAcc->currency_amount)]
            ]);
            $debitAcc->deposit($amount);
            $debitAcc->update();
            $investAcc->withdraw($amount);
            $investAcc->update();
            $message='Withdraw successful';
        }
        return redirect(route('invest.index', ['user' => $user]))->with('message',$message);
    }

    private function createInvestAccountNr(): string
    {
        $num = "ICODE";
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
