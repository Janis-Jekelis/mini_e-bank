<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<header>
    <h1>{{$user->name}}</h1>
    @if($debitAccount)
        <a href="{{ route('debit.create', $user->id) }}">Create debit account</a>
    @else
        <a href="{{ route('debit.index',['user'=>$user->id ] )}}">Debit account</a>
    @endif
    @if($investAccount)
        <a href="{{ route('invest.create', $user->id) }}">Create investment account</a>
    @else
        <a href="{{ route('invest.index',['user'=>$user->id ] )}}">Investment account</a>
    @endif

</header>
</body>
</html>


