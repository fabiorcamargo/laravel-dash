<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title}} 
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        @vite(['resources/scss/light/assets/apps/invoice-preview.scss'])
        @vite(['resources/scss/dark/assets/apps/invoice-preview.scss'])

        @vite(['resources/scss/light/assets/elements/infobox.scss', 'resources/scss/dark/assets/elements/infobox.scss'])

        
        @vite(['resources/scss/light/assets/elements/alert.scss'])
        @vite(['resources/scss/dark/assets/elements/alert.scss'])
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->
        <div class="row invoice layout-top-spacing layout-spacing">
            <div class="doc-container">
                <div class="row">
                    <div class="col-xl-10">
                        <div class="invoice-container">
                            <div class="content-section">
                                <div class="row">
                                    <div class="widget-content widget-content-area br-8">
                                        <div class="d-flex">    
                                        <h4 class=""><img src="{{Vite::asset('resources/images/logo2.svg')}}" class="navbar-logo logo-light pe-3" width="80" alt="logo">Profissionaliza EAD</h4>
                                        </div>
                                        <p class="inv-street-addr mt-3">CNPJ: 41.769.690/0001-25</p>
                                        <p class="inv-street-addr mt-3">Endereço: Av. Advogado Horácio Raccanello Filho, 5410 Sala 01, Maringá/PR, 87020-035</p>
                                    </div>       
                                </div>
                            </div>
                                        
                            <div class="content-section pt-4">
                                    <div class="row">
                                        <div class="widget-content widget-content-area br-8 ">
                                            @if (\Session::has('erro'))
                                                <div class="alert alert-light-danger alert-dismissible fade show border-0 mb-4" role="alert"> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-bs-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> {!! \Session::get('erro') !!} </div>
                                            @endif
                                            @if (\Session::has('success'))
                                                <div class="alert alert-light-sucess alert-dismissible fade show border-0 mb-4" role="alert"> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-bs-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> {!! \Session::get('success') !!} </div>
                                            @endif
                                            
                                            @if($status == "RECUSED")
                                            <div class="text-center mb-3">
                                                    <div class="info-box-1-icon" style="background-color: red">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-down"><path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"></path></svg>
                                                    </div>
                                                <div class="info-box-1-content-wrapper">
                                                    <h3 class="info-box-1-title">Pagamento Recusado</h3>
                                                    <div class="info-box-1-content"> <b>{{Auth::user()->name}}</b> sua operadora de cartões recusou seu pagamento, verifique seu limite ou utilize outro Cartão de Crédito.<br>Acesse o link abaixo para finalizar o pagamento.</div>
                                                </div>
                                                    <a class="info-box-1-button" href="#">Abrir Fatura</a>
                                            </div>

                                            @elseif($status == "CONFIRMED" || $status == "RECEIVED")
                                            <div class="text-center mb-3">
                                                    <div class="info-box-1-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>
                                                    </div>
                                                <div class="info-box-1-content-wrapper">
                                                    <h3 class="info-box-1-title">Pagamento Aprovado</h3>
                                                    <div class="info-box-1-content">Parabéns <b>{{Auth::user()->name}}</b> seu pagamento foi aprovado, clique no link abaixo para acessar seu Curso.</div>
                                                </div>
                                                <a class="info-box-1-button" href="#">Área do Aluno</a>
                                            </div>
                                            @elseif($status == "PENDING")

                                            <div class="text-center mb-3">
                                                <div class="info-box-1-icon" style="background-color: orange">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>
                                                </div>
                                            <div class="info-box-1-content-wrapper">
                                                <h3 class="info-box-1-title">Pagamento Pendente</h3>
                                                <div class="info-box-1-content"><b>{{Auth::user()->name}}</b> efetue o pagamento via pix para liberação imediata do seu conteúdo.</div>
                                            </div>
                                            <a class="info-box-1-button" href="#">Área do Aluno</a>
                                            </div>
                                            @endif
                                            {{--
                                            <div class="card bg-warning mb-4">
                                                <div class="card-body">
                                                <h5 class="card-title">Pagamento Pendente</h5>
                                                <h6 class="card-title">Para ter a liberação imediata do seu curso, faça o pagamento via pix.</p>
                                                </div>
                                            </div>
                                            <div class="card bg-danger mb-4">
                                                <div class="card-body">
                                                <h5 class="card-title">Pagamento Recusado</h5>
                                                <h6 class="card-title">A sua operadora de cartões recusou o pagamento, você pode abrir sua fatura e tantar novamente ou inserir um novo Cartão de Crédito.</p>
                                                </div>
                                            </div>
                                            --}}
                                            
                                        </div>
                                    </div>
                            </div>
                        </div>        
                    </div>
                </div>
            </div>
        </div>  
 
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{asset('node_modules/card/lib/card.js')}}"></script>
        @vite(['resources/assets/js/apps/invoice-preview.js'])

        <script src="{{asset('plugins/global/vendors.min.js')}}"></script>
        

        <script src="{{asset('plugins/input-mask/jquery.inputmask.bundle.min.js')}}"></script>
        <script src="{{asset('plugins/input-mask/input-mask2.js')}}"></script>
        <script src="{{asset('plugins/card/dist/card.js')}}"></script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>