<div>
    <h2>Teste</h2>
    <label>UF</label>
    <div class="form-group">
        <label for="title">Selecione seu Estado</label>
        <select name="state" class="form-control py-1" wire:model="estadoSelect" wire:change='estadoChange'>
            <option value="">Selecione seu Estado</option>
            @foreach ($estados as $key => $value)
            <option value="{{ $value['abbr'] }}">{{ $value['name'] }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="title">Selecione sua Cidade</label>
        <select name="city" id="city" class="form-control py-1" aria-placeholder="Cidade" wire:model="cidadeSelect">
            @foreach ($cities as $key => $value)
            <option value="{{ $value['name'] }}">{{ $value['name'] }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="title">Rua / Av / Travessa / Etc</label>
        <input class="form-control py-1" wire:model="rua">
    </div>

    <div class="form-group">
        @if(!empty($results))
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>CEP</th>
                    <th>Logradouro</th>
                    <th>Complemento</th>
                    <th>Bairro</th>
                    <th>Localidade</th>
                    <th>UF</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results as $result)
                <tr>
                    <td><button onclick="copyToClipboard('cep-{{ $loop->index }}')">Copiar</button></td>
                    <td id="cep-{{ $loop->index }}">{{ $result['cep'] }}</td>
                    <td>{{ $result['logradouro'] }}</td>
                    <td>{{ $result['complemento'] }}</td>
                    <td>{{ $result['bairro'] }}</td>
                    <td>{{ $result['localidade'] }}</td>
                    <td>{{ $result['uf'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    <div class="form-group">
        <button wire:click='getCep'>Enviar</button>
    </div>

    <script>
        function copyToClipboard(elementId) {
            var copyText = document.getElementById(elementId).innerText;
            console.log('Texto a ser copiado:', copyText);
            
            var textarea = document.createElement("textarea");
            textarea.value = copyText;
            document.body.appendChild(textarea);
            textarea.select();

            navigator.clipboard.writeText(copyText);
            
            try {
                var successful = document.execCommand("copy");
                var msg = successful ? 'bem-sucedida' : 'mal-sucedida';
                console.log('Cópia de texto foi ' + msg);
                alert("CEP copiado: " + copyText);
            } catch (err) {
                console.error('Erro ao copiar texto:', err);
            }
            
            document.body.removeChild(textarea);
        }

       
    </script>
</div>