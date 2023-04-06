    @php 
    if($event == "ViewContent"){
    $event = new App\Http\Controllers\ConversionApiFB;
    $event->ViewContent($object);
    }elseif($event == "Lead"){
    $event = new App\Http\Controllers\ConversionApiFB;
    $event->Lead();
    }elseif($event == "PageView"){
    $event = new App\Http\Controllers\ConversionApiFB;
    $event->PageView();
    };
    @endphp
