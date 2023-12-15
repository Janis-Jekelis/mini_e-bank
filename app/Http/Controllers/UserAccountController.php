<?php

namespace App\Http\Controllers;

use App\Models\UserAccount;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class UserAccountController extends Controller
{

    public function index():View
    {
        return view('index');
    }


    public function create(Request $userData):View
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request):void
    {
       var_dump($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\UserAccount $userAccount
     * @return \Illuminate\Http\Response
     */
    public function show(UserAccount $userAccount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\UserAccount $userAccount
     * @return \Illuminate\Http\Response
     */
    public function edit(UserAccount $userAccount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\UserAccount $userAccount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserAccount $userAccount)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\UserAccount $userAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserAccount $userAccount)
    {
        //
    }
}
