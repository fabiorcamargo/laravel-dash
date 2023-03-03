    @php 
    if($event == "ViewContent"){
    $event = new App\Http\Controllers\ConversionApiFB;
    $event->ViewContent();
    }elseif($event == "Lead"){
    $event = new App\Http\Controllers\ConversionApiFB;
    $event->Lead();
    }else{

    };
    @endphp
