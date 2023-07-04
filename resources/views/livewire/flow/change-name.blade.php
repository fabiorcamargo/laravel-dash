<div>
    <h6 class="s-heading" data-listTitle="Complete">{{ $name }}</h6>
    <div class="col-12">
        <a class="dropdown-item list-edit" href="javascript:void()" wire:click="abrirModal">Editar</a>

        <!-- Modal -->
        <div class="modal" tabindex="-1" role="dialog"
            style="@if($modalAberto) display: block; @else display: none; @endif">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Meu Formulário Modal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"
                            wire:click="fecharModal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="atualizar">
                            <div class="form-group">
                                <label for="nome">Nome:</label>
                                <input type="text" class="form-control" wire:model="nome" id="nome"
                                    value="{{ $nameId }}">
                            </div>

                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>