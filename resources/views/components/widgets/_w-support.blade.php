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
                <img src="{{Vite::asset('resources/images/whatsapp.svg')}}" alt="avatar">
            </div>
            <div class="media-body">
                <h6>{{$title}}</h6>
                <p class="meta-date-time">Clique no botão para acionar o Suporte.</p>
            </div>
        </div>

        <div class="card-bottom-section">
            <a href="https://wa.me/554491322034?text=Suporte" class="btn">Ajuda</a>
        </div>
    </div>
</div>