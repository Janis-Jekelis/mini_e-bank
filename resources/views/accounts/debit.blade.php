@extends('layouts.app')
@section('content')
    <h4 class="ps-2">Debit account:</h4>
    <hr>
    <div class="row ps-5">
        <div class="col-3 border-end border-black ps-0 text-center">
            <p class="mb-1">Account number</p>
            <p class="fw-bold ">{{ $user->debitAccount->account_number }}</p>
        </div>
        <div class="col-2 border-end border-black text-center ">
            <p class="mb-1">Currency</p>
            <p class="fw-bold">{{$user->debitAccount->currency}}</p>
        </div>
        <div class="col-2 border-end border-black text-center ">
            <p class="mb-1">Amount</p>
            @php($debitSum=number_format($user->debitAccount->amount/100,2))
            <p class="fw-bold">{{$debitSum}}</p>
        </div>
    </div>
    <hr>
    <form class="ps-2" method="post" action="{{route('debit.update',['user'=>$user, 'debit'=>$user])}}">
        @csrf
        @method('PUT')
        <div class="row justify-content-start align-items-center">
            <label class="col-1" for="deposit">Deposit ({{$user->currency}}):</label>
            <input class="border-black col-2 me-3" type="number" step="0.01" min="0" id="deposit"
                   name="debitAccountDeposit">
            <button class="btn btn-primary col-1" type="submit">Deposit</button>
        </div>
    </form>

    <form class="ps-2" method="post" action="{{route('debit.update',['user'=>$user, 'debit'=>$user])}}">
        @csrf
        @method('PUT')
        <div class="row justify-content-start align-items-center">
            <label class="col-1" for="transferToAccount">Receiver Account number</label>
            <input class="border-black col-2 me-3" type="text"  id="transferToAccount" name="transferToAccount">
            <label class="col-1" for="deposit">Transfer ({{$user->currency}}):</label>
            <input class="border-black col-2 me-3" type="number" step="0.01" min="0" id="deposit"
                   name="transfer">
            <button class="btn btn-primary col-1" type="submit">Transfer</button>
        </div>
    </form>
    {{$errors->first() }}

@endsection
