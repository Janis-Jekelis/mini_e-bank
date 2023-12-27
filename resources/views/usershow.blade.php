@extends('layouts.app')
@section('content')

    @if($debitAccount)
        <form method="post" action="{{ route('debit.store', ['user'=>$user]) }}">
            @csrf
            <input type="hidden">
            <button class="btn btn-primary" type="submit">Create debit account</button>
        </form>
    @else
        <h4 class="ps-2">Debit account:</h4>
        <hr>
        <div class="row ps-5">
            <div class="col-3 border-end border-black ps-0 text-center">
                <p class="mb-1">Account number</p>
                <a href="{{route('debit.index',['user'=>Auth::id()])}}" class="fw-bold ">
                    {{$user->debitAccount->account_number}}
                </a>
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
    @endif
    @if(!$debitAccount)
    @if($investAccount)
        <form method="post" action="{{ route('invest.store', ['user'=>$user]) }}">
            @csrf
            <input type="hidden">
            <button class="btn btn-primary" type="submit">Create debit account</button>
        </form>
    @else
        <h4 class="ps-2">Investment account:</h4>
        <hr>
        <div class="row ps-5">
            <div class="col-3 border-end border-black ps-0 text-center">
                <p class="mb-1">Account number</p>
                <a href="{{route('invest.index',['user'=>Auth::id()])}}" class="fw-bold">
                    {{$user->investmentAccount->account_number}}
                </a>
            </div>
            <div class="col-2 border-end border-black text-center ">
                <p class="mb-1">Currency</p>
                <p class="fw-bold">{{$user->investmentAccount->currency}}</p>
            </div>
            <div class="col-2 border-end border-black text-center ">
                <p class="mb-1">Amount</p>
                @php($investSum=number_format($user->investmentAccount->currency_amount/100,2))
                <p class="fw-bold">{{$investSum}}</p>
            </div>
        </div>
        <hr>
    @endif
    @endif
@endsection

