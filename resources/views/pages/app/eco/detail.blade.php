
<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title}} 
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        
        <link rel="stylesheet" href="{{asset('plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/glightbox/glightbox.min.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/splide/splide.min.css')}}">

        @vite(['resources/scss/light/assets/components/tabs.scss'])
        @vite(['resources/scss/light/assets/components/accordions.scss'])
        @vite(['resources/scss/light/assets/apps/ecommerce-details.scss'])
        @vite(['resources/scss/dark/assets/components/tabs.scss'])
        @vite(['resources/scss/dark/assets/components/accordions.scss'])
        @vite(['resources/scss/dark/assets/apps/ecommerce-details.scss'])    
        
        <link rel="stylesheet" href="{{asset('plugins/splide/splide.min.css')}}">
        @vite(['resources/scss/light/plugins/splide/custom-splide.min.scss'])
        @vite(['resources/scss/dark/plugins/splide/custom-splide.min.scss'])

        @vite(['resources/scss/light/assets/elements/alert.scss'])
        @vite(['resources/scss/dark/assets/elements/alert.scss'])
        
        <!--  END CUSTOM STYLE FILE  -->
        <x-fb-microdata object={!!$product!!}/>
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <x-slot:scrollspyConfig>
        data-bs-spy="scroll" data-bs-target="#navSection" data-bs-offset="100"
    </x-slot>

    <div class="row layout-top-spacing">
        @if (session('sucess'))
        <div class="alert alert-light-success alert-dismissible fade show border-0 mb-4 mt-4" role="alert"> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-bs-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> Produto atualizado com sucesso! </div>
        @endif

        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-4">

            <div class="widget-content widget-content-area br-8">
                
                @isset(Auth::user()->role)
                @if((Auth::user()->role) == 8 || (Auth::user()->role) == 3)
                <div class="col-md-12 col-sm-12 col-12 text-end">
                    <div class="product-share">
                        <a href="{{ getRouterValue(); }}/app/eco/product/{{ $product->id }}/edit" class="btn btn-light-success btn-icon btn-rounded" data-toggle="tooltip" data-placement="top" title="Edit">
                            <x-widgets._w-svg svg="settings"/>
                        </a>
                    </div>
                </div>
                @endif
                @endisset

                <div class="row justify-content-center pt-5 pb-5">
                    <div class="col-xxl-5 col-xl-6 col-lg-7 col-md-7 col-sm-9 col-12 pt">
                        <!-- Swiper -->
                        <div class="container" style="max-width: 700px">
                           
                            
                           

                            <div id="thumbnail-slider" class="splide">
                                <div class="splide__track">
                                    <ul class="splide__list">
                                        
                                        @foreach ($product->image as $image)
                                        <li class="splide__slide"><img alt="slider-image" src="{{asset("/product/$image")}}"></li>
                                        @endforeach
                                        
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-xxl-4 col-xl-5 col-lg-12 col-md-12 col-12 mt-xl-0 mt-5 align-self-center">

                        <div class="product-details-content">
                            
                            {!! $product->perc !!}
                            
                            <h3 class="product-title mb-0">{{ $product->name }}</h3>
                            
                            <div class="review mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                <span class="rating-score">4.88 {{--<span class="rating-count">(200 Reviews)</span></span>--}}
                            </div>

                            <div class="row">

                                <div class="col-md-9 col-sm-9 col-9">

                                    <div class="pricing">

                                        <span class="discounted-price">R${{ $product->price }}</span>
                                        <span class="regular-price">R${{ $product->oprice}}</span>
                                        
                                    </div>
                                    
                                </div>
                                <div class="col-md-3 col-sm-3 col-3 text-end">
                                    <div class="product-share">
                                        <button class="btn btn-light-success btn-icon btn-rounded">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-share-2"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg>
                                        </button>
                                    </div>
                                </div>
                                
                            </div>                                            

                            <hr class="mb-4">
                            
                            <div class="row color-swatch mb-4">
                                
                                    
                                    <div class="color-options text-xl">
                                        <div class="row">
                                            <div class="">
                                                
                                                {!! $product->description !!}
                                                
                                                
                                            </div>
                                        </div>
                                        {{--
                                        <div class="form-check form-check-inline">

                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault3">
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault4" checked>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault5">
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault6">
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault7">
                                        </div> --}}
                                    </div>
                                
                            </div>
{{--
                            <div class="row size-selector mb-4">
                                <div class="col-xl-9 col-lg-6 col-sm-6 align-self-center">Size</div>
                                <div class="col-xl-3 col-lg-6 col-sm-6 align-self-center">
                                    <select class="form-select form-control-sm" aria-label="Default select example">
                                        <option value="S">S</option>
                                        <option value="M">M</option>
                                        <option value="L" selected>L</option>
                                        <option value="XL">XL</option>
                                        <option value="2XL">2XL</option>
                                    </select>
                                    <a href="javascript:void(0);" class="product-helpers text-end d-block mt-2">Size Chart</a>
                                </div>
                            </div>

                            <div class="row quantity-selector mb-4">
                                <div class="col-xl-6 col-lg-6 col-sm-6 mt-sm-3">Quantity</div>
                                <div class="col-xl-6 col-lg-6 col-sm-6">
                                    <input id="demo1" type="text" value="1" name="demo1">
                                    <p class="text-danger product-helpers text-end mt-2">Low Stock</p>
                                </div>
                            </div>--}}

                            <hr class="mb-5 mt-4">

                            <div class="action-button text-center">

                                <div class="row">
                                    
                                   
                                    <div class="col-xxl-7 col-xl-7 col-sm-6 mb-sm-0 mb-3">
                                        <a href="/modern-light-menu/app/eco/checkout/{{ $product->id }}" class="btn btn-success w-100 btn-lg" type="send"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg> <span class="btn-text-inner">Adicionar no Carrinho</span></a>
                                    </div>
                                  
                                    {{--
                                    <div class="col-xxl-5 col-xl-5 col-sm-6">
                                        <button class="btn btn-success w-100 btn-lg">Comprar</button>
                                    </div>--}}
                                    
                                </div>
                                
                            </div>

                            <div class="secure-info mt-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shield"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                                <p>Pagamento %100 seguro, transações criptografadas TLS/SSL</p>
                            </div>
                            
                        </div>
                        
                    </div>
                </div>

            </div>

        </div>

        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-4">

            <div class="widget-content widget-content-area br-8">

                <div class="production-descriptions simple-pills">

                    <div class="pro-des-content">

                        <div class="row">
                            <div class="col-xxl-6 col-xl-8 col-lg-9 col-md-9 col-sm-12 mx-auto">
                                <div class="product-reviews mb-5">
                                        
                                    <div class="row">
                                        <div class="col-sm-6 align-self-center">
                                            <div class="reviews">
                                                <h1 class="mb-0">4.88</h1>
                                                <span>Pontuação das Avaliações</span>
                                                <div class="stars mt-3 mb-sm-0 mb-4">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star empty-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">

                                            <div class="row review-progress mb-sm-1 mb-3">
                                                <div class="col-sm-4">
                                                    <p>5</p>
                                                </div>
                                                <div class="col-sm-8 align-self-center">
                                                    <div class="progress">
                                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row review-progress mb-sm-1 mb-3">
                                                <div class="col-sm-4">
                                                    <p>4</p>
                                                </div>
                                                <div class="col-sm-8 align-self-center">
                                                    <div class="progress">
                                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row review-progress mb-sm-1 mb-3">
                                                <div class="col-sm-4">
                                                    <p>3</p>
                                                </div>
                                                <div class="col-sm-8 align-self-center">
                                                    <div class="progress">
                                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row review-progress mb-sm-1 mb-3">
                                                <div class="col-sm-4">
                                                    <p>2</p>
                                                </div>
                                                <div class="col-sm-8 align-self-center">
                                                    <div class="progress">
                                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row review-progress mb-sm-1 mb-3">
                                                <div class="col-sm-4">
                                                    <p>1</p>
                                                </div>
                                                <div class="col-sm-8 align-self-center">
                                                    <div class="progress">
                                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                        
                        
                        <div id="iconsAccordion" class="accordion-icons accordion">

                            <div class="card">
                                <div class="card-header" id="headingTwo3">
                                    <section class="mb-0 mt-0">
                                        <div role="menu" class="collapsed" data-bs-toggle="collapse" data-bs-target="#iconAccordionTwo" aria-expanded="false" aria-controls="iconAccordionTwo">
                                            <div class="accordion-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg></div>
                                            Principais Avaliações  <div class="icons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
                                        </div>
                                    </section>
                                </div>
                                <div id="iconAccordionTwo" class="collapse" aria-labelledby="headingTwo3" data-bs-parent="#iconsAccordion">
                                    <div class="card-body">
                                
                                        <div class="row">
                                                                                                        
                                            <div class="col-md-12 mx-auto">
                                                @if($product->comments != null)
                                                @foreach ($product->comments as $comment)
                                                <div class="media mb-4">
                                                    <div class="avatar me-sm-4 mb-sm-0 me-0 mb-3">
                                                        <img alt="avatar" src="{{asset($comment->img)}}" class="rounded-circle">
                                                    </div>
                                                    <div class="media-body">
                                                        <h4 class="media-heading mb-1">{{$comment->name}}</h4>
                                                        <div class="stars">
                                                            @for ($i = 0; $i < 5; $i++)
                                                                @if($comment->star > $i)
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                                                @else
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star empty-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                                                @endif
                                                            @endfor
                                                        </div>
                                                        <div class="meta-tags">a min ago</div>
                                                        <p class="media-text mt-2">{{$comment->comment}}</p>
                                                    </div>
                                                </div>
                                                @endforeach
                                                @endif
                                                
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card">
                                <div class="card-header" id="headingOne3">
                                    <section class="mb-0 mt-0">
                                        <div role="menu" class="collapsed" data-bs-toggle="collapse" data-bs-target="#iconAccordionOne" aria-expanded="false" aria-controls="iconAccordionOne">
                                            <div class="accordion-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg></div>
                                            Detalhes  <div class="icons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
                                        </div>
                                    </section>
                                </div>

                                <div id="iconAccordionOne" class="collapse" aria-labelledby="headingOne3" data-bs-parent="#iconsAccordion">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                {!! $product->specification !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="card">
                                <div class="card-header" id="headingOne4">
                                    <section class="mb-0 mt-0">
                                        <div role="menu" class="collapsed" data-bs-toggle="collapse" data-bs-target="#iconAccordionFour" aria-expanded="false" aria-controls="iconAccordionFour">
                                            <div class="accordion-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg></div>
                                            Detalhes da Entrega  <div class="icons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
                                        </div>
                                    </section>
                                </div>

                                <div id="iconAccordionFour" class="collapse" aria-labelledby="headingOne4" data-bs-parent="#iconsAccordion">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">

                                                <h5><strong>Detalhes da Entrega</strong></h5>
                                                <hr/>
                                                <p class="mb-2">Todos os nossos produtos são entregues de forma automática.</p>
                                                <p class="mb-5">Na página de Checkout você terá opções como Pix e Cartão que são compensados logo após o momento da compra e o sistema já faz a liberação do seu produto.</p>
                                                <p class="mb-5">Agora se você optar por pagamento via Boleto Bancário, o sistema só libera após a compensação do Boleto.</p>
                                            
                                            </div>
                                        </div>
                                    </div>
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
        <script src="{{asset('plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js')}}"></script>
        <script src="{{asset('plugins/glightbox/glightbox.min.js')}}"></script>
        <script src="{{asset('plugins/splide/splide.min.js')}}"></script>
        <script src="{{asset('plugins/splide/custom-splide.js')}}"></script>
        @vite(['resources/assets/js/apps/ecommerce-details.js'])

        <script>
            fbq("track", "ViewContent",
            {
                "event_name": "ViewContent",
                "event_time": "{{ time() }}",
                "action_source": "website",
                "event_source_url": "{{ url()->current() }}",
                "eventID": "{{ Cookie::get('fbid') }}",
                "user_data": {
                    "client_ip_address": "{{$_SERVER['REMOTE_ADDR']}}",
                    "client_user_agent": "{{$_SERVER['HTTP_USER_AGENT']}}"
                    @isset($_COOKIE['_fbp'])
                    ,"fbp": "{{$_COOKIE['_fbp']}}",
                    "fbc": "{{$_COOKIE['_fbp']}}.{{ Cookie::get('fbid') }}"
                    @endisset
                },
                "custom_data": {
                    "content_ids": "product_{{$product->id}}",
                    "content_category": "{{json_decode($product->tag)[0]->value}}",
                    "content_name": "{{$product->name}}"
                }
            }
            )
            </script>

    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
<x-fb-event event="ViewContent" object={!!$product!!}/>