<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title}}
        </x-slot>

        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <x-slot:headerFiles>
            <!--  BEGIN CUSTOM STYLE FILE  -->
            <link rel="stylesheet" href="{{asset('plugins/table/datatable/datatables.css')}}">
            <link rel="stylesheet" href="{{asset('plugins/tagify/tagify.css')}}">

            <link rel="stylesheet" href="{{asset('plugins/filepond/filepond.min.css')}}">
            <link rel="stylesheet" href="{{asset('plugins/filepond/FilePondPluginImagePreview.min.css')}}">

            @vite(['resources/scss/light/plugins/tagify/custom-tagify.scss'])
            @vite(['resources/scss/dark/plugins/tagify/custom-tagify.scss'])

            @vite(['resources/scss/light/assets/components/modal.scss'])
            @vite(['resources/scss/dark/assets/components/modal.scss'])

            @vite(['resources/scss/light/assets/elements/alert.scss'])
            @vite(['resources/scss/dark/assets/elements/alert.scss'])

            @vite(['resources/scss/light/plugins/filepond/custom-filepond.scss'])
            @vite(['resources/scss/dark/plugins/filepond/custom-filepond.scss'])

            @vite(['resources/scss/light/assets/components/list-group.scss'])
            @vite(['resources/scss/light/assets/users/user-profile.scss'])
            @vite(['resources/scss/dark/assets/components/list-group.scss'])
            @vite(['resources/scss/dark/assets/users/user-profile.scss'])

            @vite(['resources/scss/light/plugins/clipboard/custom-clipboard.scss'])
            @vite(['resources/scss/dark/plugins/clipboard/custom-clipboard.scss'])
            <!--  END CUSTOM STYLE FILE  -->

            <style>
                #ecommerce-list img {
                    border-radius: 18px;
                }
            </style>
            </x-slot>
            <!-- END GLOBAL MANDATORY STYLES -->


            <div class="row layout-spacing">

                <!-- Content -->
                <div class="col-12 col-sm-10 col-md-8 col-lg-8 col-xl-6 col-xxl-6  layout-top-spacing">
                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4 text-success" :status="session('status')" />

                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />
                    <div class="user-profile">
                        <div class="widget-content widget-content-area">
                            @if(isset($link))
                            <div class="text-center">
                                <h3 class="ps-2 pb-2">Lista de Pagamentos</h3>
                                <p class="pb-4 ps-2">{{Auth::user()->name}} Você optou por link de pagamento, abaixo
                                    você pode acompanhar o status.</p>
                                <div class="media-body">


                                    @if($link['status'] == "PENDING")
                                    <div class="text-center">
                                        <x-widgets._w-svg class="text-warning" svg="circle-check-filled"
                                            style="width: 40px; height: 40px" />
                                    </div>
                                    <div>
                                    <h5 class="mb-0 pt-2 text-warning text-center"> STATUS: PENDENTE
                                    </div>
                                    <div class="row pt-5">
                                        <a href="{{$link['url']}}" type="button" target="_blank" class="btn btn-warning btn-lg btn-block">
                                            <x-widgets._w-svg class="text-white"
                                                                            svg="cash" />PAGAMENTO</a>
                                    </div>
                                        @elseif($link['status'] == "OVERDUE")
                                        <div class="text-center">
                                            <x-widgets._w-svg class="text-danger" svg="circle-check-filled"
                                                style="width: 40px; height: 40px" />
                                        </div>
                                        <div>
                                        <h5 class="mb-0 pt-2 text-danger text-center"> STATUS: ATRASADO
                                        </div>
                                        <div class="row pt-5">
                                            <a href="{{$link['url']}}" type="button" target="_blank" class="btn btn-danger btn-lg btn-block">
                                                <x-widgets._w-svg class="text-white"
                                                                                svg="cash" />PAGAMENTO</a>
                                        </div>
                                            @elseif($link['status'] == "RECEIVED" ||
                                            $link['status'] == "CONFIRMED" ||
                                            $link['status'] == "RECEIVED_IN_CASH")

                                            <div class="text-center">
                                                <x-widgets._w-svg class="text-success" svg="circle-check-filled"
                                                    style="width: 40px; height: 40px" />
                                            </div>
                                            <div>
                                            <h5 class="mb-0 pt-2 text-success text-center"> STATUS: PAGO
                                            </div>
                                            <div class="row pt-5">
                                                <a href="{{$link['url']}}" type="button" target="_blank" class="btn btn-success btn-lg btn-block">
                                                    <x-widgets._w-svg class="text-white"
                                                                                    svg="cash" />PAGAMENTO</a>
                                            </div>

                                                @endif
                                </div>
                            </div>
                            @else
                            <div class="">
                                <h3 class="ps-2 pb-2">Lista de Pagamentos</h3>
                                <p class="pb-4 ps-2">{{Auth::user()->name}} abaixo estão listadas as mensalidades e
                                    status de pagamento</p>
                            </div>



                            <div id="tableSimple" class="col-lg-12 col-12 layout-spacing mt-2">
                                <div class="statbox widget box box-shadow">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Parcelas</th>
                                                </tr>
                                            </thead>


                                            <tbody>
                                                @foreach ($cobrancas as $cobranca)

                                                <!-- MODAL SEÇÃO -->
                                                <div id="DivOuroComboModal{{$cobranca->id}}"
                                                    class="modal animated fadeInDown" role="dialog">
                                                    <div class="modal-dialog">
                                                        <!-- Modal content-->
                                                        <div class="modal-content">

                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Pagamento via PIX</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                    <svg aria-hidden="true"
                                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="feather feather-x">
                                                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                                                    </svg>
                                                                </button>
                                                            </div>

                                                            @if($cobranca->billingType !== "CREDIT_CARD")
                                                            <div class="modal-body">
                                                                <div class="info-box-1-content-wrapper text-justify ">


                                                                    <div class="info-box-1-content">
                                                                        <b>{{Auth::user()->name}}</b> o pagamento
                                                                        pode ser efetuado de duas formas<br>
                                                                        1ª - Capturando o QRCODE no seu
                                                                        aplicativo bancário.<br>
                                                                        2ª - Clicando no botão
                                                                        Copiar, para utilizar a função Pix Copia e
                                                                        Cola.
                                                                    </div>
                                                                    @php $pix =
                                                                    App\Http\Controllers\OldAsaasController::getqrcode($cobranca->id,
                                                                    $i)
                                                                    @endphp
                                                                </div>
                                                                @if(!isset($pix->errors))

                                                                <div class="info-box-1-content-wrapper text-center ">
                                                                    <img class="col-12 col-sm-8 col-md-6 col-lg-6 col-xl-6 col-xxl-6"
                                                                        src="data:image/jpeg;base64, {{$pix->encodedImage}}" />

                                                                    <div class="clipboard-input">

                                                                        <div class="copy-icon jsclipboard cbBasic form-control"
                                                                            data-bs-trigger="click" title="Copiado"
                                                                            data-clipboard-target="#copy-basic-input">
                                                                            <input type="text"
                                                                                class="form-control inative"
                                                                                id="copy-basic-input"
                                                                                value="{{ $pix->payload }}">

                                                                            <div class="btn btn-primary  mb-2 me-4">
                                                                                <x-widgets._w-svg class="text-white"
                                                                                    svg="copy" />
                                                                                <span
                                                                                    class="btn-text-inner">Copiar</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>


                                                                </div>
                                                                @endif
                                                            </div>


                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <!-- MODAL SEÇÃO -->


                                                <tr>
                                                    <td class="">
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="media-body">

                                                                    @if($cobranca->status == "OVERDUE")
                                                                    <div class="text-center">
                                                                        <x-widgets._w-svg class="text-danger"
                                                                            svg="circle-x-filled"
                                                                            style="width: 40px; height: 40px" />
                                                                    </div>
                                                                    <h5 class="mb-0 text-danger text-center"> Atrasada
                                                                        {{
                                                                        \Carbon\Carbon::parse($cobranca->dueDate)->format('d/m/y')
                                                                        }}</h5>
                                                                    <p>


                                                                        {{$cobranca->description}}
                                                                    </p>
                                                                    @elseif( $cobranca->status == "PENDING" )
                                                                    <p>

                                                                    <p class="mb-0">
                                                                        <x-widgets._w-svg class="text-warning"
                                                                            svg="circle-check-filled" /> Vencimento: {{
                                                                        \Carbon\Carbon::parse($cobranca->dueDate)->format('d/m/Y')
                                                                        }}
                                                                    </p>
                                                                    {{$cobranca->description}}
                                                                    </p>
                                                                    @php $status = "" @endphp
                                                                    @elseif($cobranca->status == "RECEIVED" ||
                                                                    $cobranca->status == "CONFIRMED" ||
                                                                    $cobranca->status == "RECEIVED_IN_CASH")
                                                                    <p>

                                                                    <p class="mb-0 text-success">
                                                                        <x-widgets._w-svg class="text-success"
                                                                            svg="circle-check-filled" /> Pago: {{
                                                                        \Carbon\Carbon::parse($cobranca->paymentDate)->format('d/m/Y')
                                                                        }}
                                                                    </p>
                                                                    {{$cobranca->description}}
                                                                    </p>
                                                                    @php $status = "" @endphp
                                                                    @endif




                                                                </div>
                                                                <div class="col">
                                                                    @if($cobranca->status == "RECEIVED" ||
                                                                    $cobranca->status == "CONFIRMED" ||
                                                                    $cobranca->status == "RECEIVED_IN_CASH")
                                                                    <a href="{{$cobranca->invoiceUrl}}" target="_blank"
                                                                        class="btn btn-light-success p-1 col-12">
                                                                        <x-widgets._w-svg class="text-success"
                                                                            svg="file-dollar" />
                                                                        <span class="btn-text-inner">Fatura</span>
                                                                    </a>
                                                                    @else
                                                                    <a href="{{$cobranca->bankSlipUrl}}" target="_blank"
                                                                        class="btn btn-light-primary p-1 col-6">
                                                                        <x-widgets._w-svg class="text-primary"
                                                                            svg="cash" />
                                                                        <span class="btn-text-inner">Boleto</span>
                                                                    </a>
                                                                    <a href="" data-bs-toggle="modal"
                                                                        data-bs-target="#DivOuroComboModal{{$cobranca->id}}"
                                                                        class="btn btn-light-success p-1 ms-2 col-6">
                                                                        <x-widgets._w-svg class="text-success"
                                                                            svg="qrcode" />
                                                                        <span class="btn-text-inner">PIX</span>
                                                                    </a>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>

            <!--  BEGIN CUSTOM SCRIPTS FILE  -->
            <x-slot:footerFiles>
                <script type="module" src="{{asset('plugins/global/vendors.min.js')}}"></script>
                <script src="{{asset('plugins/tagify/tagify.min.js')}}"></script>
                @vite(['resources/assets/js/custom.js'])
                <script src="{{asset('plugins/filepond/filepond.min.js')}}"></script>
                <script src="{{asset('plugins/filepond/FilePondPluginImageExifOrientation.min.js')}}"></script>
                <script src="{{asset('plugins/filepond/FilePondPluginImagePreview.min.js')}}"></script>

                <script type="module" src="{{asset('plugins/table/datatable/datatables.js')}}"></script>

                <script src="{{asset('plugins/clipboard/clipboard.min.js')}}"></script>
                <script type="module" src="{{asset('plugins/clipboard/custom-clipboard.min.js')}}">
                    <script src="{{asset('plugins/tagify/tagify.min.js')}}">
                </script>

                </x-slot>
                <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>