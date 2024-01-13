{{--

/**
*
* Created a new component
<x-rtl.widgets._w-card-one />.
*
*/

--}}

<div data-draggable="true" class="card task-text-progress">
    <div class="widget widget-card-one" style="background: #191e3a;">
        <div class="widget-content">
            <div>
                <a href="{{ getRouterValue(); }}/aluno/profile/{{$id}}" class="media">
                    <div class="w-img">
                        <img src="{{asset($image)}}" alt="avatar">
                    </div>

                    <div class="media-body">
                        <h6>{{$name}}</h6>
                        @if($today == 1)
                        <p class="meta-date-time">Hoje</p>
                        @else
                        <p class="meta-date-time">{{$date}}</p>
                        @endif
                    </div>
                </a>
            </div>


            <div class="w-action">
                <div class="row">
                    <div class="badge--group pd-0">
                        <div class="badge badge-success badge-dot"></div>
                        <p class="m-0 ps-1">{{$product}}</p>
                    </div>

                    {{--}}
                    <div class="card-like">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-thumbs-up">
                            <path
                                d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3">
                            </path>
                        </svg>
                        <span>551 Likes</span>
                    </div>


                    <div class="read-more">
                        <a href="javascript:void(0);">Read More <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-right">
                                <polyline points="13 17 18 12 13 7"></polyline>
                                <polyline points="6 17 11 12 6 7"></polyline>
                            </svg></a>
                    </div>--}}
                    <div class="badge--group pd-0">
                        <div class="badge badge-primary mb-2 me-4">{{$seller}}</div>
                    </div>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a data-bs-toggle="modal" data-bs-target="#EditCertModal" type="button"
                            class="badge badge-warning mb-2 bs-tooltip" title="Editar">
                            <x-widgets._w-svg class="text-white" svg="edit" />
                        </a>

                        <a href="{{ getRouterValue(); }}/aluno/profile/{{$id}}" target="_blank" type="button"
                            class="badge badge-secondary mb-2 bs-tooltip" title="Ver Perfil">
                            <x-widgets._w-svg class="text-white" svg="arrow-up-right" />
                        </a>

                        <a data-bs-toggle="modal" data-bs-target="#exampleModal" type="button"
                            class="badge badge-danger mb-2 bs-tooltip" title="Excluir">
                            <x-widgets._w-svg class="text-white" svg="trash" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>