<x-mail::message>
# Novo certificado emitido!

Clique no botão abaixo para visualizar, seu certificado também está disponível no seu perfil de usuário na plataforma de estudos.

<x-mail::button :url="$url">
Acessar
</x-mail::button>

Atenciosamente,<br>
{{ config('app.name') }}
</x-mail::message>
