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
            @php($investSum=number_format($user->investmentAccount->currency_amount/100,2))
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

    <div class="container">
        <div class="row">
            @foreach($assets as $symbol=>$assetValue)
                <div class="col-3">
                    <div class="card"
                         onmouseover="handleMouseover(this)"
                         onmouseout="handleMouseout(this)"
                    >
                        @php($value=number_format($assetValue,2))
                        <span class="active">{{$symbol}}: {{$value }} {{$user->currency}}</span>
                        <div class="buy" style="display: none">
                            <form method="post" action="{{route('invest.update',['user'=>$user, 'invest'=>$user])}}"
                                  class="card-body d-flex justify-content-around align-items-center">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="assetName" value="{{$symbol}}">
                                <label for="{{$symbol}}">Amount:</label>
                                <input class="border-black col-1 me-3 w-25" type="number" step="0.01" min="0"
                                       id="{{$symbol}}"
                                       name="assetAmount">
                                <button class="btn btn-primary col-1 w-25" type="submit">Buy</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @foreach($ownedAssets as $ownedAsset)
        <p>{{$ownedAsset->name}} {{$ownedAsset->open_rate}} {{$ownedAsset->amount}}</p>
    @endforeach

    <script>
        function handleMouseover(card) {
            card.querySelector('.buy').style.display = 'block';
            card.querySelector('.active').style.fontWeight = 'bold';
        }

        function handleMouseout(card) {
            card.querySelector('.buy').style.display = 'none';
            card.querySelector('.active').style.fontWeight = 'inherit';
        }
    </script>
@endsection
