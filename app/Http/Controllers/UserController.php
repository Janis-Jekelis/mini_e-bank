<?php

namespace App\Http\Controllers;

use App\Models\accounts\DebitAccount;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class UserController extends Controller
{

    public function index(): View
    {
        return view('index', ['users' => User::all()]);
    }

    public function create(): View
    {
        return view('usercreate', ['currencies' => ['EUR', 'GBP', 'USD']]);
    }

    public function store(Request $request)
    {
        $user = (new User)->fill([
            'name' => $request->input('name'),
            'surname' => $request->input('surname'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'currency' => $request->input('currency')
        ]);
        $user->save();
        return redirect()->route('home.store');
    }

    public function show($id): View
    {
        $user = (User::findOrFail($id));
        $debitAccount = false;
        $investAccount = false;
        if (!isset($user->DebitAccount)) $debitAccount = true;
        if (!isset($user->InvestmentAccount)) $investAccount = true;
        return view(
            'usershow',
            [
                'user' => $user,
                'debitAccount'=>$debitAccount,
                'investAccount'=>$investAccount
            ]);

    }

    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
