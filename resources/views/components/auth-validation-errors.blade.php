@props(['errors'])

@if ($errors->any())
    <div {{ $attributes }}>
       {{--}} <div class="font-medium text-red-600">
            {{ __('Whoops! Something went wrong.') }}
        </div>--}}

        <ul class="alert alert-light-danger alert-dismissible fade show border-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
