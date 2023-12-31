@extends('layouts.app')
@section('content')
    <h4 class="ps-2">Investment account:</h4>
    <hr>
    <div class="row ps-5 d-flex align-items-center">
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
        <div class="col-4 d-flex">
            <div class="col-4 text-center">
                <button class="btn btn-primary" onclick="
            document.querySelector('.deposit').style.display = 'block';
            document.querySelector('.withdraw').style.display = 'none';">
                    Deposit
                </button>
            </div>
            <div class="col-4 text-center">
                <button class="btn btn-primary" onclick="
            document.querySelector('.deposit').style.display = 'none';
            document.querySelector('.withdraw').style.display = 'block';">
                    Withdraw
                </button>
            </div>
            <div class="col-4 text-end">
                <form method="post"
                      action="{{route('invest.destroy',['user'=>$user,'invest'=>$user])}}"
                      onsubmit="return confirm('Close debit account?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        Close account
                    </button>
                </form>
            </div>
        </div>
    </div>
    <hr>
    <form class="ps-2 ms-5 deposit"
          method="post"
          action="{{route('invest.update',['user'=>$user, 'invest'=>$user])}}"
          style="display: none">
        @csrf
        @method('PUT')
        <div class="row justify-content-start align-items-center">
            <label class="col-1" for="deposit">Deposit ({{$user->currency}}):</label>
            <input class="border-black col-2 me-3" type="number" step="0.01" min="0" id="deposit"
                   name="investAccountDeposit">
            <button class="btn btn-primary col-1" type="submit">Deposit</button>
        </div>
    </form>
    <form class="ps-2 ms-5 withdraw"
          method="post"
          action="{{route('invest.update',['user'=>$user, 'invest'=>$user->id])}}"
          style="display: none">
        @csrf
        @method('PUT')
        <div class="row justify-content-start align-items-center">
            <label class="col-1" for="withdraw">Withdraw ({{$user->currency}}):</label>
            <input class="border-black col-2 me-3" type="number" step="0.01" min="0" id="withdraw"
                   name="withdraw">
            <button class="btn btn-primary col-1" type="submit">Withdraw</button>
        </div>
    </form>
    <div class="container mt-3">
        <h2 class="text-center mb-4">Asset catalog</h2>
        <div class="row">
            @foreach($assets as $symbol=>$assetValue)
                <div class="col-3">
                    <div class="card mb-1"
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
            <div class="d-flex justify-content-center mt-2">{{ $assets->links() }}</div>
        </div>
    </div>
    <div class="container mt-4">
        @unless(count($ownedAssets)==0)
            <h2 class="text-center">Owned assets</h2>
        @endunless
        <div class="row">
            @foreach($ownedAssets as $ownedAsset)
                <div class="col-3">
                    <div class="card mb-1"
                         onmouseover="this.querySelector('.ownedAsset').style.display = 'block';"
                         onmouseout="this.querySelector('.ownedAsset').style.display = 'none';">
                        @php([$currentRate,$currentValue]=$ownedAsset->getCurrentRateAndValue())
                        @php($color='')
                        @if($currentRate>$ownedAsset->open_rate)
                            @php($color='green')
                        @elseif($currentRate<$ownedAsset->open_rate)
                            @php($color='red')
                        @endif
                        <p class="text-center" style="color:{{$color}}">{{$ownedAsset->amount}} {{$ownedAsset->name}}
                            : {{$currentValue}} {{$user->currency}}
                        </p>
                        <div class="ownedAsset" style="display: none">
                            <form class="ps-2 " method="post"
                                  action="{{route('invest.update',['user'=>$user, 'invest'=>$user])}}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="soldAsset" value="{{$ownedAsset->id}}">
                                <label class="col-2 ps-2" for="{{$ownedAsset->id}}">Sell</label>
                                <input class="border-black col-2 me-3 w-25" type="number" step="0.01" min="0"
                                       id="{{$ownedAsset->id}}"
                                       name="assetSellAmount">
                                <button class="btn btn-primary col-1 w-25 mb-3" type="submit">Sell</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
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
    @if ($errors->any())
        <script>
            window.onload = function () {
                window.alert("{{ $errors->first() }}");
            };
        </script>
    @endif
@endsection
