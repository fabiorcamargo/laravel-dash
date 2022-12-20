<a class="card mb-md-0 mb-4" href="{{ App\Models\Cademi::where('user_id', (Auth::user()->id))->value('login_auto') }}" target="_blank">
    <img src="{{Vite::asset('resources/images/product-2.jpg')}}" class="card-img-top" alt="...">
    <div class="card-footer">
        <div class="row">
            <div class="col-6">
                <b>Preparatório Bancário</b>
            </div>
            <div class="col-6 text-end">
                <p class="text-success mb-0">80%</p>
            </div>
        </div>
        <div class="progress br-30">
            <div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>
</a>

