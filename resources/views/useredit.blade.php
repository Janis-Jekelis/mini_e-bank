@extends('layouts.app')
@section('content')
    <body>
    <div class="container">
        <form method="post" action={{route('home.update',['home'=>$user])}}>
            @method('PUT')
            @csrf
            <div class="row d-flex align-items-center mb-2">
                <label class="col-1 text-end fw-bold" for="name">Name:</label>
                <input class="col-2" type="text" name="name" id="name" value="{{$user->name}}">
            </div>
            <div class="row d-flex align-items-center mb-2">
                <label class="col-1 text-end fw-bold" for="surname">Surname:</label>
                <input class="col-2" type="text" name="surname" id="surname" value="{{$user->surname}}">
            </div>
            <div class="row d-flex align-items-center mb-2">
                <label class="col-1 text-end fw-bold" for="email">Email:</label>
                <input class="col-2" type="text" name="email" id="email" value="{{$user->email}}">
            </div>
            <div class="row d-flex align-items-center mb-2">
                <div class="col-3 text-end">
                <button class="btn btn-primary w-50 fw-bold" type="submit">&#9999 Edit</button>
                </div>
            </div>
        </form>
    </div>
    </body>
@endsection
