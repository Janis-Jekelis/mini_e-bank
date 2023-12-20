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
@if(strpos(url()->current(),'debit'))
    @php($route='debit.store')
    <h2>Enter your password to create debit account </h2>
@endif
@if(strpos(url()->current(),'invest'))
    <h2>Enter your password to create investment account </h2>
    @php($route='invest.store')
@endif
<form method="post" action={{ route($route, $user->id) }}>
        @csrf
        <label for="password"></label>
        <input type="password" name="password" id="password">
        <label for="confirm-password"></label>
        <input type="password" name="confirmPassword" id="confirm-password">
        <button type="submit">Create</button>
    </form>
</body>
</html>
