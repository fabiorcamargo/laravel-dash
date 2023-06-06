<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
                
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
    
    <title>Certificado</title>
    <style>
        @page {
      size: A4 landscape;
      margin: 0;

    }
        .one {

            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            background-image: url({{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('Certificado.png')))}});

        }

        .two {

        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        background-image: url({{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('Certificado-verso.png')))}});

        }

        .container {
            padding-top: 30%;
            width: 500px;
            height: 300px;
        }

        .container h1 {
            
            font-size: 40px;
            margin-bottom: 30px;
            color: black;
        }
        .container h2 {
            
            font-size: 30px;
            padding-bottom: 22%;
            color: black;
        }

        .container p {
            font-size: 24px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body class="one">
    <div class="container">
        <h1 class="text-center display-1">FÁBIO CAMARGO</h1>
        <h2 class="text-center display-1 fixed-bottom">AGENTE BANCÁRIO</h2>
    </div>
</body>
<body class="two">
    <div class="container">
        <h1 class="text-center display-1">FÁBIO CAMARGO</h1>
        <h2 class="text-center display-1 fixed-bottom">{{\Carbon\Carbon::now()->timestamp}}</h2>
    </div>
</body>
</html>
