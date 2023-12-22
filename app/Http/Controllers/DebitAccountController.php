<?php

namespace App\Http\Controllers;

use App\Models\accounts\DebitAccount;
use App\Models\User;
use App\Rules\Amount;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
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

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user): RedirectResponse
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

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $deposit = $request->get('debitAccountDeposit');
        if ($deposit !== null) {
            $debitAcc = $user->debitAccount()->get()->first();

            $debitAcc->deposit($deposit);
            $debitAcc->update();
        }
        if($request->get('transferToAccount')!==null || $request->get('transfer')!==null ) {
            $request->validate([
                'transferToAccount' => 'required|exists:debit_accounts,account_number',
                'transfer' => [
                    'required',
                    new Amount(),
                    'gt:0'
                ]
            ]);
            $receiver = DebitAccount::where('account_number', $request->get('transferToAccount'))->get()->first();
            $receiver->debitAccount->deposit($request->get('transfer'));
        }
        return redirect(route('home.show', ['home' => $user]));
    }

    public function destroy($id)
    {
        //
    }
}
