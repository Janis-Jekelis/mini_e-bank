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
<form method="post" action={{route('store')}}>
    @csrf
    @method('PUT')
    <label for="name">Name:</label>
    <input type="text" name="name" id="name">
    <label for="surname">Surname:</label>
    <input type="text" name="surname" id="surname">
    <label for="email">Email:</label>
    <input type="text" name="email" id="email">
    <label for="password">Password:</label>
    <input type="password" name="password" id="password">
    <label for="password-confirm">Confirm password:</label>
    <input type="password" name="passwordConfirm" id="password-confirm">
    <label for="currency"></label>
    <select id="currency">
        @foreach($currencies as $currency)
            <option value={{$currency}}>{{$currency}}</option>
        @endforeach
    </select>
    <button type="submit">Register</button>
    </form>

</body>
</html>
