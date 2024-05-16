<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title}}

    </x-slot:pageTitle>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->

        <link rel="stylesheet" href="{{asset('plugins/table/datatable/datatables.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/tagify/tagify.css')}}">

        <link rel="stylesheet" href="{{asset('plugins/filepond/filepond.min.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/filepond/FilePondPluginImagePreview.min.css')}}">

        @vite(['resources/scss/light/assets/components/modal.scss'])
        @vite(['resources/scss/dark/assets/components/modal.scss'])

        @vite(['resources/scss/light/assets/elements/alert.scss'])
        @vite(['resources/scss/dark/assets/elements/alert.scss'])

        @vite(['resources/scss/light/assets/components/list-group.scss'])
        @vite(['resources/scss/light/assets/users/user-profile.scss'])
        @vite(['resources/scss/dark/assets/components/list-group.scss'])
        @vite(['resources/scss/dark/assets/users/user-profile.scss'])


        <!-- END GLOBAL MANDATORY STYLES -->
    </x-slot:headerFiles>

    <div class="row layout-spacing">
        <!-- Content -->
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-top-spacing">
            <div class="user-profile">
                <div class="widget-content widget-content-area">
                    <div class="d-flex justify-content-between">
                        <h3 class="mb-4">Lista de Grupos</h3>
                        {{--<a data-bs-toggle="modal" href="" data-bs-target="#OuroComboCreateModal"
                            class="mt-2 edit-profile" data-toggle="tooltip" data-placement="top" title="Criar Combo">
                            <x-widgets._w-svg svg="text-plus" />
                        </a>--}}
                    </div>
                    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
                        <div class="widget-content widget-content-area">
                            <div id="tableSimple" class="col-lg-12 col-12 layout-spacing mt-2">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">Nome</th>
                                                <th scope="col">Descrição</th>
                                                <th scope="col">Link</th>
                                                <th scope="col">Expira</th>
                                                <th class="text-center dt-no-sorting">Ação</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($groups as $group)
                                            <tr>
                                                <td>
                                                    {{$group->name}}
                                                </td>

                                                <td>
                                                    {{$group->description}}
                                                </td>

                                                <td>
                                                    <div class="action-btns">
                                                        <a href="{{$group->link}}" target="_blank">{{$group->link}}</a>
                                                    </div>
                                                </td>

                                                <td>
                                                    {{$group->expire}}
                                                </td>

                                                <td>
                                                    Editar
                                                </td>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
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
        <script src="{{asset('plugins/global/vendors.min.js')}}"></script>
        <script src="{{asset('plugins/table/datatable/datatables.js')}}"></script>

    </x-slot:footerFiles>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>