<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel SPA with Vue</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body>

<div id="app">
    <product-component></product-component>
</div>


<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>