@extends('layouts.app')
@section('content')
    <body>
    <div class="container">
        <div class="card col-4 d-flex align-items-center pt-3 pb-3">
            <form method="post" action={{route('home.update',['home'=>$user])}}>
                @method('PATCH')
                @csrf
                <div class="row d-flex align-items-center mb-2">
                    <label class="col-4 text-end  fw-bold" for="name">Name:</label>
                    <input class="col-6" type="text" name="name" id="name" value="{{old('name',$user->name)}}">
                </div>
                <div class="row d-flex align-items-center mb-2">
                    <label class="col-4 text-end fw-bold" for="surname">Surname:</label>
                    <input class="col-6" type="text" name="surname" id="surname"
                           value="{{old('surname',$user->surname)}}">
                </div>
                <div class="row d-flex align-items-center mb-2">
                    <label class="col-4 text-end fw-bold" for="email">Email:</label>
                    <input class="col-6" type="text" name="email" id="email" value="{{old('email',$user->email)}}">
                </div>
                <div class="row d-flex align-items-center mb-2 me-1">
                    <div class="col-11 pe-3 text-end justify-content-center">
                        <button class="btn btn-primary w-50  fw-bold" type="submit">&#9999 Edit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </script>
    @if ($errors->any())
        <script>
            window.onload = function () {
                window.alert("{{ $errors->first() }}");
            };
        </script>
    </body>
    @endif
@endsection
