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


page[n="1"]{
    background-size:contain;
            background-repeat: no-repeat;
            background-position: center;
    background-image: url({{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('Certificado.png')))}});

  display: block;
  margin: 0 auto;
  box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
  
  
}
page[n="2"]{
  background-size:contain;
    background-repeat: no-repeat;
    background-position: center;
    background-image: url({{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('Certificado-verso.png')))}});

  display: block;
  margin: 0 auto;
  
  box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
  
  
  
}
page[size="A4"] {  
  width: 20cm;
  height: 29.7cm; 
}
page[size="A4"][layout="landscape"] {
  width: 29.7cm;
  height: 791px;  
  display: flex;
 
    align-items: center; //centraliza horizontalmente
    
    
    justify-content: center; //cetraliza verticalmente*/
    
    
    
}

page div.relative {
  position: relative;
  width: 1185px;
  height: 790px;
  
  border: 5px solid #ffffff;*/
} 


.name {
    position: absolute;
  top: 330px;
  right: 0;
  width: 1110px;
  height: 50px;
  /*border: 3px solid #73AD21;*/

            font-size: 25px;
            color: black;
            text-transform: uppercase;
}

.course {
    position: absolute;
  top: 500px;
  right: 0;
  width: 1110px;
  height: 50px;
  /*border: 3px solid #2d21ad;*/
  
            font-size: 25px;
            color: black;
            text-transform: uppercase;
}

.conteudo {
    
    padding-inline: 50px;
    position: absolute;
  top: 130px;
  right: 0;
  width: 1120px;
  height: 380px;
  
  /*border: 3px solid #ad3621;*/

}

.empresa {
  position: absolute;
  top: 530px;
  right: 0;
  width: 1120px;
  height: 200px;
  /*border: 3px solid #2126ad;*/
}

.qr {
    position: absolute;
  padding: 25px;
  right: 0;
  width: 200px;
  height: 200px;
  /*border: 3px solid #2126ad;*/
}

.conteudo h2 {
    top: 0;
    font-size: 18px;
    color: black;
}



.empresa h2 {
    font-size: 18px;
    color: black;
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
<div class="container">
  <div class="py-5 text-center">
    <img class="d-block mx-auto mb-4" src="{{Vite::asset('resources/images/Logo-Vetorial.png')}}" alt="" width="300" height="300">
    <p class="lead pb-2"> <b>Sistema de Verificação de Certificados</b></p>
    <p class="lead">Abaixo seguem as informações do certificado emitido.</p>
    <a href="{{route('cert-down', ['code' => $cert->code])}}" class="btn btn-danger text-white mt-4">Baixar PDF</a>
  </div>
</div>

    <page size="A4" layout="landscape" n="1">
        <div class="relative">
            <h1 class="text-center name">{{$cert->getuser()->name}} {{$cert->getuser()->lastname}}</h1>
            
            <h1 class="text-center course">{{ $cert->getCertModel()->name }}</h1>
        </div>
    </page>
  
    <page size="A4" layout="landscape" n="2">
        <div class="relative">
          
            <div class="qr">{{ QrCode::size(150)->generate(asset("cert/$cert->code")) }}</div>
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
           
        
    </page>

</html>
