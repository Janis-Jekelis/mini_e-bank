@extends('layouts.app')
@section('content')
    <h4 class="ps-2">Debit account:</h4>
    <hr>
    <div class="row ps-5 d-flex align-items-center">
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
        <div class="col-4 d-flex">
            <div class="col-3 text-center">
                <button class="btn btn-primary" onclick="
                    document.querySelector('.deposit').style.display = 'block';
                    document.querySelector('.transfer').style.display = 'none';
                    document.querySelector('.withdraw').style.display = 'none';">
                    Deposit
                </button>
            </div>
            <div class="col-3 text-center">
                <button class="btn btn-primary" onclick="
                    document.querySelector('.deposit').style.display = 'none';
                    document.querySelector('.transfer').style.display = 'none';
                    document.querySelector('.withdraw').style.display = 'block';">
                    Withdraw
                </button>
            </div>
            <div class="col-3 text-center">
                <button class="btn btn-primary" onclick="
                    document.querySelector('.withdraw').style.display = 'none';
                    document.querySelector('.deposit').style.display = 'none';
                    document.querySelector('.transfer').style.display = 'block';">
                    Transfer
                </button>
            </div>
            <div class="col-3 text-end">
                <form method="post"
                      action="{{route('debit.destroy',['user'=>$user,'debit'=>$user])}}"
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
          action="{{route('debit.update',['user'=>$user, 'debit'=>$user])}}"
          style="display: none">
        @csrf
        @method('PUT')
        <div class="row justify-content-start align-items-center">
            <label class="col-1" for="deposit">Deposit ({{$user->currency}}):</label>
            <input class="border-black col-2 me-3" type="number" step="0.01" min="0" id="deposit"
                   name="debitAccountDeposit">
            <button class="btn btn-primary col-1" type="submit">Deposit</button>
        </div>
    </form>
    <form class="ps-2 ms-5 withdraw"
          method="post"
          action="{{route('debit.update',['user'=>$user, 'debit'=>$user->id])}}"
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
    <form class="ps-2 ms-5 transfer"
          method="post"
          action="{{route('debit.update',['user'=>$user, 'debit'=>$user])}}"
          style="display: none">
        @csrf
        @method('PUT')
        <div class="row justify-content-start align-items-center">
            <label class="col-1" for="transferToAccount">Receiver Account number</label>
            <input class="border-black col-2 me-3" type="text" id="transferToAccount" name="transferToAccount">
            <label class="col-1" for="deposit"> Transfer sum ({{$user->currency}}): </label>
            <input class="border-black col-2 me-3" type="number" step="0.01" min="0" id="deposit"
                   name="transfer">
            <button class="btn btn-primary col-1" type="submit">Transfer</button>
        </div>
    </form>
    @if ($errors->any())
        <script>
            window.onload = function () {
                window.alert("{{ $errors->first() }}");
            };
        </script>
    @endif
@endsection
