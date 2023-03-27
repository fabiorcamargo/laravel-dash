<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title}} 
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="row layout-top-spacing">
        <div class="col-lg-3 col-md-3 col-sm-3 mb-4">
            {{--<input id="t-text" type="text" name="txt" placeholder="Search" class="form-control" required="">--}}
        </div>
        @isset(Auth::user())
        @if((Auth::user()->role) == 8 || (Auth::user()->role) == 3)
        <div class="col-xl-2 col-lg-3 col-md-3 col-sm-3 mb-4 ms-auto">
            <div class="form-check form-check-primary form-check-inline">
                <form action="{{ getRouterValue(); }}/app/eco/shop" method="post" enctype="multipart/form-data" name="form" id="form" class="needs-validation" novalidate>
                    @csrf
                    <input type="text" name="public" id="public" value="{{$public}}" hidden>
                         <button type="send" class="btn btn-dark  mb-2">
                            @if($public == 0)
                            <x-widgets._w-svg svg="eye"/>
                            @elseif($public ==1)
                            <x-widgets._w-svg svg="eye-off"/>
                            @endif
                            <span class="btn-text-inner">Não listados</span>
                        </button>
                </form>
            </div>
        </div>
        @endif
        @endisset
            {{--
            <select class="form-select form-select" aria-label="Default select example">
                <option selected="">All Category</option>
                <option value="3">Apperal</option>
                <option value="1">Electronics</option>
                <option value="2">Clothing</option>
                <option value="3">Accessories</option>
                <option value="3">Organic</option>
            </select>
            --}}
    </div>
{{--
        <div class="col-xl-2 col-lg-3 col-md-3 col-sm-3 mb-4">
            <select class="form-select form-select" aria-label="Default select example">
                <option selected="">Sort By</option>
                <option value="1">Low to High Price</option>
                <option value="2">Most Viewed</option>
                <option value="3">Hight to Low Price</option>
                <option value="3">On Sale</option>
                <option value="3">Newest</option>
            </select>
        </div>--}}

    
    <div class="row">
        @foreach ($products as $product)
        <div class="col-xl-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 mb-4">
            
            <a class="card style-6" href="{{getRouterValue();}}/app/eco/product/{{$product->id}}">
                <span class="badge badge-primary">{{$product->percent *100}}% OFF</span>            
                <img src="{{asset("/product/$product->thumb")}}" class="card-img-top" alt="...">
                <div class="card-footer">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <b>{{$product->name}}</b>

                        </div>
                        <div class="col-3">
                            <div class="badge--group">
                                @if((Auth::user()->role) == 8 || (Auth::user()->role) == 3)
                                
                                        @if($product->public == 1)
                                            <x-widgets._w-svg class="text-info" svg="eye"/>
                                        @elseif($product->public == 0)
                                            <x-widgets._w-svg class="text-warning" svg="eye-off"/>
                                        @endif
                                
                                @else
                                        <div class="badge badge-danger badge-dot"></div>
                                        <div class="badge badge-info badge-dot"></div>
                                @endif
                            </div>
                        </div>
                        <div class="col-9 text-end">
                            <div class="pricing d-flex justify-content-end">
                                <h5 class="text-success mb-0 me-1">R$ {{ $product->price}}</h5>
                                @if($product->percent > 0)
                                <p class="mb-0 line-through" style="color:darkgrey "><del>R$ {{ number_format(($product->price / (1-$product->percent)),0) }}</del></p>
                                @endif
                            </div>
                        </div>
                            
                    </div>
                </div>
            </a>
        </div>  
        

        @endforeach
       

    </div>
    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>

    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>