<x-mail::message>
# Obrigado por se Cadatrar

{{ $user->name }} estamos muito felizes em ter você conosco, abaixo estão os seus dados de acesso:

Login: {{ $user->username }}

Senha: {{ $user->password }}

<x-mail::button :url="URL::to('/login')">
Entrar
</x-mail::button>

Atenciosamente,<br>
{{ config('app.name') }}
</x-mail::message>
