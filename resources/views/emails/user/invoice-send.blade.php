<x-mail::message>
# Sua fatura foi gerada com sucesso!

Clique no botão abaixo para acessá-la:

<x-mail::button :url="$invoice">
Fatura
</x-mail::button>


Caso precise de ajuda chame nosso <a style="color:#48bb78" class="text-success" href="https://wa.me/5544984233200?text=Suporte">suporte via Whatsapp</a>:

Atenciosamente,<br>
</x-mail::message>