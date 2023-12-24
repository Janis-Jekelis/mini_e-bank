@extends('layouts.app')
@section('content')
    <h4 class="ps-2">Investment account:</h4>
    <hr>
    <div class="row ps-5">
        <div class="col-3 border-end border-black ps-0 text-center">
            <p class="mb-1">Account number</p>
            <p class="fw-bold ">{{ $user->investmentAccount->account_number }}</p>
        </div>
        <div class="col-2 border-end border-black text-center ">
            <p class="mb-1">Currency</p>
            <p class="fw-bold">{{$user->investmentAccount->currency}}</p>
        </div>
        <div class="col-2 border-end border-black text-center ">
            <p class="mb-1">Amount</p>
            @php($investSum=number_format($user->investmentAccount->amount/100,2))
            <p class="fw-bold">{{$investSum}}</p>
        </div>
    </div>
    <hr>

    <form class="ps-2" method="post" action="{{route('invest.update',['user'=>$user, 'invest'=>$user])}}">
        @csrf
        @method('PUT')
        <div class="row justify-content-start align-items-center">
            <label class="col-1" for="deposit">Deposit ({{$user->currency}}):</label>
            <input class="border-black col-2 me-3" type="number" step="0.01" min="0" id="deposit"
                   name="investAccountDeposit">
            <button class="btn btn-primary col-1" type="submit">Deposit</button>
        </div>
    </form>
    {{$errors->first() }}
@endsection
