@php $object = (json_decode($object)) @endphp

<meta property="og:title" content="{{$object->name}}">
<meta property="og:description" content="{{$object->description}}">
<meta property="og:url" content="{{url()->current()}}">
<meta property="og:image" content="{{env('URL_CATALOG_PRODUCT_IMG') . ($object->image[0])}}">
<meta property="product:brand" content="Profissionaliza EAD">
<meta property="product:availability" content="in stock">
<meta property="product:condition" content="new">
<meta property="product:price:amount" content="{{$object->price}}">
<meta property="product:price:currency" content="BRL">
<meta property="product:retailer_item_id" content="product_{{$object->id}}">