{{-- 

/**
*
* Created a new component <x-rtl.widgets._w-card-two/>.
* 
*/

--}}



<div class="widget widget-card-two">
    <div class="widget-content">

        <div class="media">
            <div class="w-img">
                <img src="{{$img}}" alt="avatar">
            </div>
            <div class="media-body">
                <h6>{{$title}}</h6>
                <p class="meta-date-time">{{$desc}}</p>
            </div>
        </div>

        <div class="card-bottom-section pt-4">
            <h4 class="text-dark d-inline">Você pagará</h4>
            <h4 class="col text-success d-inline md-4" id="prec">{{$price}}</h4>
            <div class="img-group pt-2" hidden>
                <img src="{{Vite::asset('resources/images/profile-19.jpeg')}}" alt="avatar">
                <img src="{{Vite::asset('resources/images/profile-6.jpeg')}}" alt="avatar">
                <img src="{{Vite::asset('resources/images/profile-8.jpeg')}}" alt="avatar">
                <img src="{{Vite::asset('resources/images/profile-3.jpeg')}}" alt="avatar">
            </div>
            <div class="pt-4">
                <div class="d-grid gap-2">
            <button type="send" class="btn button_card" id="button_finalizar">Finalizar</button>
            </div>
            </div>
        </div>
    </div>
</div>