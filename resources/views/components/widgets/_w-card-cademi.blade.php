<a class="card mb-md-0 mb-4" href="{{ App\Models\Cademi::where('user_id', (Auth::user()->id))->value('login_auto') }}" target="_self">
    <img src="{{Vite::asset($card)}}" class="card-img-top" alt="Seu Curso">
    <div class="card-footer">
        <div class="row">
            <div class="col-6">
                <b>{{ $title }}</b>
            </div>
            <div class="col-6 text-end">
                <p class="text-success mb-0">0%</p>
            </div>
        </div>
        <div class="progress br-30">
            <div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>
</a>

