@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Profissionaliza EAD')
<img src="{{Vite::asset('resources/images/Logo-Vetorial-300.png')}}"
                                                        class="navbar-logo logo-light pe-3" width="200"
                                                        alt="Profissionaliza EAD">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
