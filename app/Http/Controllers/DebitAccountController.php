<?php

namespace App\Http\Controllers;

use App\Models\accounts\DebitAccount;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(User $user): View
    {
        return view('accounts.debitcreate',['user'=>$user]);
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
        echo "lllasdasdasd";
        $debitAccount->user()->associate($user);
        $debitAccount->save();
        return redirect()->route('home.index');
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

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
