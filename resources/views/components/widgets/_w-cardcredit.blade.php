<div class="row">
                                                                        
    <div class="card-wrapper pb-1"></div>
    
    <div class="col-md-6"> 
        <div class="mb-3">
            <label class="form-label">Número do Cartão</label>
            <input type="tel" id="number" name="number" placeholder="Igual Impresso no Cartão" class="form-control add-payment-method-input">
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">            
            <label class="form-label">Nome</label>
            <input type="text" id="holderName" placeholder="Igual Impresso no Cartão" name="name" class="form-control">
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label">Validade</label>
            <input type="text" id="expiry" name="expiry" class="form-control">
        </div>
    </div>
    <div class="col-md-2">
        <div class="mb-3">
            <label class="form-label">CVV/CVV2</label>
            <input type="text" id="cvc" name="cvc" class="form-control">
        </div>
    </div>
    <div class="col-md-3">
        <div class="mb-3">
            <label class="form-label">Cep:</label>
            <input name="cep" type="text" id="cep" class="cep-number form-control" maxlength="9" onchange="pesquisacep(this.value);"/><span class="badge badge-light-success mb-2 me-4">Buscar</span>
        </div>
    </div>
</div>




    

    <div id="end"  class="row" hidden>
    <div class="col-md-10">    
    <label class="form-label">Rua: </label>
    <input name="rua" type="text" id="rua"  class="form-control" />
    </div>
    <div class="col-md-2"> 
    <label class="form-label">Número:</label>
    <input name="numero" type="text" id="numero" class="form-control" />
    </div>
    <div class="col-md-12"> 
    <label class="form-label">Bairro:</label>
    <input name="bairro" type="text" id="bairro"class="form-control"/>
    </div>
    <div class="col-md-8"> 
    <label class="form-label">Cidade:</label>
    <input name="cidade" type="text" id="cidade" class="form-control"/>
    </div>
    <div class="col-md-2"> 
    <label class="form-label">Estado:</label>
    <input name="uf" type="text" id="uf" class="form-control" />
    </div>
    </div>
