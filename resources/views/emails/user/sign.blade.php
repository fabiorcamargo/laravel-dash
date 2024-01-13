<x-mail::message>
# Obrigado por se Cadatrar

{{ $user->name }} estamos muito felizes em ter você conosco, abaixo estão os seus dados de acesso:

Login: {{ $user->username }}

Senha: {{ $user->password }}

<x-mail::button :url="URL::to('/login')">
Entrar
</x-mail::button>

Caso precise de ajuda chame nosso <a style="color:#48bb78" class="text-success" href="https://wa.me/5544984233200?text=Suporte%20cadastro%20online!">suporte via Whatsapp</a>:

Atenciosamente,<br>
{{ config('app.name') }}
</x-mail::message>
