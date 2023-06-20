<div>
@foreach ($notifies as $key => $notify)


<div class="dropdown-item col-12" id="notify[{{$notify->id}}]">
    
    <div class="media server-log">
        <x-widgets._w-svg class="text-{{$notify->status}}" svg="{{$notify->icon}}"/> 
        <a href="{{$notify->action}}" class="media-body" target="_blank">
            <div class="data-info">
                <h6 class="">{{$notify->resume}}</h6>
                <p class="">{{$notify->updated_at->format('d-m-y H:m')}}</p>
            </div>
        </a>
        <div wire:click="dismiss({{$notify->id}})" class="icon-status">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </div>
    </div>
    
</div>
@endforeach
</div>