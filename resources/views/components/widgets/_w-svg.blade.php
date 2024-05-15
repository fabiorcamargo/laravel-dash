{{-- 
Exemplo da lâmina
<x-widgets._w-svg svg="message-plus"/> 
--}}
<svg {{ $attributes }} width="24" height="24">
    <use xlink:href="{{asset('svg/tabler-sprite.svg').'#tabler-'.$svg }}" />
</svg>
