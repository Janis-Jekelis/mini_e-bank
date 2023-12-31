<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
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
                'debitAccount' => $debitAccount,
                'investAccount' => $investAccount
            ]);
    }

    public function edit(): View
    {
        return view('useredit', ['user' => Auth::user()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'min:2'],
            'surname' => ['required', 'string', 'max:255', 'min:2'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->email, 'email'),
            ],
        ]);
        $user->update([
            'name' => $request->get('name'),
            'surname' => $request->get('surname'),
            'email' => $request->get('email')
        ]);
        return redirect(route('home.show', ['home' => $user]));
    }


    public function destroy(): RedirectResponse
    {
        $user = Auth::user();
        $debitAcc = $user->debitAccount()->get()->first();
        $investAcc = $user->investmentAccount()->get()->first();
        if ($debitAcc !== null && $investAcc !== null) {
            return redirect()->route('home.edit', ['home' => $user])->withErrors([

                'errors' => 'Before deleting profile make sure all accounts are closed'
            ]);
        }
        $user->delete();
        return redirect('/home');
    }
}
