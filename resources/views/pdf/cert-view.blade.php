<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
                
    {{--<link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />--}}
    <link href="/css/app.css" rel="stylesheet">
    
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

div.relative {
  position: relative;
  width: 100%;
  height: 790px;
  
} 


.name {
    position: absolute;
  top: 410px;
  right: 0;
  width: 100%;
  height: 50px;
  /*border: 3px solid #73AD21;*/

            font-size: 25px;
            color: black;
            text-transform: uppercase;
}

.course {
    position: absolute;
  top: 620px;
  right: 0;
  width: 100%;
  height: 50px;
  /*border: 3px solid #2d21ad;*/
  
            font-size: 25px;
            color: black;
            text-transform: uppercase;
}

.conteudo {
    
    margin: 50px;
    position: absolute;
  top: 230px;
  right: 0;
  width: 90%;
  height: 380px;
  
  /*border: 3px solid #ad3621;*/

}

.empresa {
    margin: 50px;
  position: absolute;
  top: 680px;
  right: 0;
  width: 90%;
  height: 200px;
  /*border: 3px solid #2126ad;*/
}

.qr {
    position: absolute;
  right: 0;
  margin: 50px;
  width: 150px;
  height: 150px;
  /*border: 3px solid #2126ad;*/
}

h1 {
    top: 0;
    font-size: 22px;
    color: black;
    font-family: "Roboto";
}

.conteudo h2 {
    top: 0;
    font-size: 18px;
    color: black;
    font-family: "Roboto";
}



.empresa h2 {
    font-size: 18px;
    color: black;
    font-family: "Roboto";
}

@media print{
  
  @page {
    size: A4 landscape;
    margin: 0 !important; 
    padding: 0 !important;
  }
}

    </style>
</head>
  


      <body class="one">
        <div class="relative">
            <h1 class="text-center name">{{$cert->getuser()->name}} {{$cert->getuser()->lastname}}</h1>
            
            <h1 class="text-center course">{{ $cert->getCertModel()->name }}</h1>
        </div>
    </body>
  
      <body class="two">
        <div class="relative">
            
            <div class="qr">
                <img src="data:image/png;base64, {{ base64_encode(QrCode::generate(asset("/cert/$cert->code"))) }} " style="height: 100%; width: 100%;">
            </div>
            
            {{--<div class="qr">{!! QrCode::size(150)->generate('{{asset("cert/$cert->code")}}') !!}</div>--}}
            <div class="conteudo">
                
                
                    <h2 class="text-center">CERTIFICADO REGISTRADO</h2><br>
                    <h2 class="text-center">CÓDIGO DE REGISTRO: <a href="{{route('cert-check', ['code' => $cert->code])}}">{{$cert->code}}</a></h2><br>
                    <h2 class="text-center">{{$cert->getCertModel()->content}}</h2><br><br>
                    <h2 class="text-center">CARGA HORÁRIA: {{$cert->getCertModel()->hours}}hs</h2><br><br><br><br>
            </div>

            <div class="empresa">
                <h2 class="text-center">
                    CURSO MINISTRADO E RECONHECIDO POR:<br>
                    PROFISSIONALIZA CURSOS - LTDA<br>
                    CNPJ: 24.104.429/0001-40<br><br>
                    <a href="https://profissionalizaead.com.br">https://profissionalizaead.com.br</a></h2><br>
                    <h2 class="text-center">Avenida Horácio Racanello Filho, 5410,
                        Bairro Novo Centro - CEP 87.020-035<br>MARINGÁ - PR</h2>
            </div>
        </div>
      </body>

</html>
