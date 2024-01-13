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
            width: 1100px;
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

        .container h3 {
            font-size: 24px;
            margin-bottom: -50px;
        }
    </style>
</head>
<body>
    <page size="A4" layout="landscape"></page>
</body>
<body class="one">
    <div class="container">
        <h1 class="text-center display-1">{{$cert->getuser()->name}} {{$cert->getuser()->lastname}}</h1>
        
        <h2 class="text-center display-1 fixed-bottom">{{$cert->getCertModel()->name}}</h2>
    </div>
</body>
<body class="two">
    <div class="container" style="padding-top: 10%;">
        <h1 class="text-center ">CERTIFICADO REGISTRADO <br> </h1>
        <h2 class="text-center "> CÓDIGO DE REGISTRO: <a href="{{route('cert-check', ['code' => $cert->code])}}">{{$cert->code}}</a><br><br><br>{{$cert->getCertModel()->content}}<br><br><br>CARGA HORÁRIA: {{$cert->getCertModel()->hours}}hs</h2>
        <h3 class="text-center ">
            CURSO MINISTRADO E RECONHECIDO POR:<br>
            PROFISSIONALIZA CURSOS - LTDA<br>
            CNPJ: 24.104.429/0001-40<br>
            Avenida Horácio Racanello Filho, 5410,
            Bairro Novo Centro - CEP 87.020-035
            MARINGÁ - PR<br>
            <a href="https://profissionalizaead.com.br">https://profissionalizaead.com.br</a></h3>
    </div>
        

</body>
</html>
