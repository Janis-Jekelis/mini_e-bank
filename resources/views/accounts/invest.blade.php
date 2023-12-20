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
<form method="post"  action="{{ route('invest.update',['user'=>$user->id, 'invest'=>$user->id]) }}" >
    @csrf
    @method('PUT')
<label for="deposit">Deposit</label>
    <input type="number" step="0.01" min="0" id="deposit" name="investmentAccountDeposit">
    <button type="submit">Deposit</button>
</form>

</body>
</html>
