<html>
    <body>
        <img src="{{Vite::asset('resources/images/logo2.svg')}}" class="navbar-logo logo-light pe-3" width="80" alt="logo">Profissionaliza EAD</h4>
        <p>Olá {{$user->name}}!</p>
        <p></p>
        <p>Seu cadastro na Melhor Plataforma de Estudos foi concluído com sucesso, abaixo estão os dados de acesso.</p>
        <p></p>
        <p></p>
        <p>Id/Email de Acesso: {{$user->username}}</p>
        <p>Senha Inicial: {{$user->password}}</p>
        <p>Endereço: <a href="https://alunos.profissionalizaead.com.br/login">ead.profissionalizaead.com.br</a></p>
        <p></p>
        <p></p>
        <p></p>
        <p></p>
        <p>Att, <br>
        Profissionaliza EAD!</p>
    </body>
</html>