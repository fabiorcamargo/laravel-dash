@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Profissionaliza EAD')
<img src={{Vite::asset('resources/images/logo2.svg')}} class="logo" alt="Profissionaliza EAD">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
