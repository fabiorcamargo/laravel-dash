{{-- 

/**
*
* Created a new component <x-rtl.widgets._w-wallet-one/>.
* 
*/

--}}


<div class="widget widget-wallet-one">
    
    <div class="wallet-info text-center mb-3">

        <p class="wallet-title mb-3">{{$title}}</p>
        
        <p class="total-amount mb-3">{{$value}}</p>

        @isset($svg)
        <x-widgets._w-svg svg="{{$svg}}" class="{{$cla}}"/>
        @endisset

    </div>


    {{--<div class="wallet-action text-center d-flex justify-content-around">
                
        <button class="btn btn-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
            <span class="btn-text-inner">Topup</span>
        </button>
                
        <button class="btn btn-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right-circle"><circle cx="12" cy="12" r="10"></circle><polyline points="12 16 16 12 12 8"></polyline><line x1="8" y1="12" x2="16" y2="12"></line></svg>
            <span class="btn-text-inner">Send</span>
        </button>
        
    </div>--}}
    
</div>