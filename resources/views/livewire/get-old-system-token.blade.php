<div>
    <!-- Exibir mensagem de erro -->
    
    <a class="card mb-4 mx-0 px-0" href="{{$link}}" target="_self">
        
        <img src="{{asset($card)}}" class="card-img-top" alt="Seu Curso">
        <div class="card-footer">
            <div class="row">
                <div class="col-6">
                    <b @if($errorMessage) class="text-danger" @endif>{{ $title }}</b>
                </div>
                {{--<p class="card-text">{{ $description }}</p>--}}
                {{--}}
                <div class="col-6 text-end">
                    <p class="text-success mb-0">0%</p>
                </div>
                --}}
            </div>{{--}}
            <div class="progress br-30">
                <div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>--}}
        </div>
    </a>
    
</div>
