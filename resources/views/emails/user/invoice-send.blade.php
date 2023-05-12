<x-mail::message>
# Sua fatura foi gerada com sucesso!

{{json_encode($invoice)}}

Clique no botão abaixo para acessá-la:

<x-mail::button :url="URL::to("#")">
Entrar
</x-mail::button>

Caso precise de ajuda chame nosso <a style="color:#48bb78" class="text-success" href="https://wa.me/5544984233200?text=Suporte">suporte via Whatsapp</a>:

Atenciosamente,<br>
{{ config('app.name') }}
</x-mail::message>