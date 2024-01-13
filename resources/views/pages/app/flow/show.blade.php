<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title}}
        </x-slot>

        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <x-slot:headerFiles>
            <!--  BEGIN CUSTOM STYLE FILE  -->
            @vite(['resources/scss/light/assets/components/modal.scss'])
            @vite(['resources/scss/light/assets/apps/scrumboard.scss'])

            @vite(['resources/scss/dark/assets/components/modal.scss'])
            @vite(['resources/scss/dark/assets/apps/scrumboard2.scss'])

            <link rel="stylesheet" href="{{asset('plugins/apex/apexcharts.css')}}">

            @vite(['resources/scss/light/assets/components/list-group.scss'])
            @vite(['resources/scss/light/assets/widgets/modules-widgets.scss'])

            @vite(['resources/scss/dark/assets/components/list-group.scss'])
            @vite(['resources/scss/dark/assets/widgets/modules-widgets.scss'])
            
            <!--  END CUSTOM STYLE FILE  -->
            </x-slot>
            <!-- END GLOBAL MANDATORY STYLES -->

            <div class="action-btn layout-top-spacing mb-5">
                {{--<button id="add-list" class="btn btn-secondary">Add List</button>--}}
            </div>
            <div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" aria-labelledby="addTaskModalTitle"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="add-task-title modal-title" id="addTaskModalTitleLabel1">Add Task</h5>
                            <h5 class="edit-task-title modal-title" id="addTaskModalTitleLabel2">Edit Task</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="compose-box">
                                <div class="compose-content" id="addTaskModalTitle">
                                    <div class="addTaskAccordion" id="add_task_accordion">
                                        <div class="task-content task-text-progress">
                                            <div id="collapseTwo" class="collapse show"
                                                data-parent="#add_task_accordion">
                                                <div class="task-content-body">
                                                    <form action="javascript:void(0);">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="task-title mb-4 d-flex">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="feather feather-edit-3 me-3 align-self-center">
                                                                        <path d="M12 20h9"></path>
                                                                        <path
                                                                            d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z">
                                                                        </path>
                                                                    </svg>
                                                                    <input id="s-task" type="text" placeholder="Task"
                                                                        class="form-control" name="task">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="task-badge d-flex">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="feather feather-star me-3">
                                                                        <polygon
                                                                            points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                                                        </polygon>
                                                                    </svg>
                                                                    <textarea id="s-text" placeholder="Task Text"
                                                                        class="form-control" name="taskText"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn" data-bs-dismiss="modal"><svg xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-x">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg> <span class="btn-text-inner">Discard</span></button>
                            <button data-btnfn="addTask" class="btn add-tsk btn-primary">Add Task</button>
                            <button data-btnfn="editTask" class="btn edit-tsk btn-success"
                                style="display: none;">Save</button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Modal -->
            <div class="modal fade" id="deleteConformation" tabindex="-1" role="dialog"
                aria-labelledby="deleteConformationLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content" id="deleteConformationLabel">
                        <div class="modal-header">
                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-trash-2">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path
                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                    </path>
                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                </svg>
                            </div>
                            <h5 class="modal-title" id="exampleModalLabel">Delete the task?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p class="">If you delete the task it will be gone forever. Are you sure you want to
                                proceed?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger" data-remove="task">Delete</button>
                        </div>
                    </div>
                </div>
            </div>




            <div class="row scrumboard" id="cancel-row">
                <div class="col-lg-12 layout-spacing">

                    <div class="task-list-section" id="task_list">
                        @for ($i = 0; $i < $flow->steps; $i++)
                            @php $f = $flow->id @endphp

                            <div data-section="{{$i}}" class="task-list-container" data-connect="sorting">
                                <div class="connect-sorting">
                                    <div class="task-container-header">

                                        <div class="row">
                                            <livewire:flow.change-name n={{$i}} f={{$f}} />
                                        </div>
                                    </div>
                                    
                                    <div class="connect-sorting-content" data-sortable="true">

                                        @foreach ($flow_entries as $entry)
                                        
                                        @if($entry->step == $i)
                                        @php ( $product = (isset(json_decode($entry->body)->product[0]->name)) ?
                                        json_decode($entry->body)->product[0]->name : "vazio" ) @endphp
                                        <x-widgets._w-card-crm-one id="{!!$entry->user->id!!}"
                                            name="{!!$entry->user->name!!} {!!$entry->user->lastname!!}"
                                            image="{!!$entry->user->image!!}"
                                            date="{{$entry->created_at->format('d/m/y H:i')}}"
                                            today="{{\Carbon\Carbon::parse($entry->created_at)->isToday() ? 1 : 0}}"
                                            product="{{$entry->get_product()->name}}"
                                            seller="{{$entry->get_seller->user->id}} {{$entry->get_seller->user->name}}" />

                                        @endif
                                        @endforeach
                                    </div>


                                    <div class="add-s-task">
                                        <a class="addTask"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-plus-circle">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <line x1="12" y1="8" x2="12" y2="16"></line>
                                                <line x1="8" y1="12" x2="16" y2="12"></line>
                                            </svg> Add Task</a>
                                    </div>

                                </div>
                            </div>
                            @endfor
                    </div>
                </div>
            </div>

            <!--  BEGIN CUSTOM SCRIPTS FILE  -->
            <x-slot:footerFiles>
                <script src="{{asset('plugins/global/vendors.min.js')}}"></script>
                <script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>

                <script>
                    function ShowModal(){
                
                $('#addListModal[0]').modal('show');
            }
                </script>

                <script>
                    const ps1 = new
                    PerfectScrollbar('#task_list');
                    const ps2 = new
                    PerfectScrollbar('#messages');
                </script>

                </x-slot>
                <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>