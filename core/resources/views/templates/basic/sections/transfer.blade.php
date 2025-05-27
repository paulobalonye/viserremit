@php
    $transferContent = getContent('transfer.content', true);
    $transferElements = getContent('transfer.element', false, null, true);
@endphp
<div class="section">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-lg-6 col-xl-5">
                <h3 class="mt-0">{{ __(@$transferContent->data_values->heading) }}</h3>
                <p class="section__para">
                    {{ __(@$transferContent->data_values->description) }}
                </p>
                <div class="row g-4">

                    <div class="col-md-6">
                        <ul class="list list--column list--base">
                            @foreach (@$transferElements ?? [] as $transferElement)
                                @if ($loop->even)
                                    <li class="list--column__item">
                                        {{ __($transferElement->data_values->key_features) }}
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list list--column list--base">
                            @foreach (@$transferElements ?? [] as $transferElement)
                                @if ($loop->odd)
                                    <li class="list--column__item">
                                        {{ __($transferElement->data_values->key_features) }}
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
                <a href="{{ $transferContent->data_values->button_link ?? '' }}" class="btn btn--xl btn--base mt-4">
                    {{ __(@$transferContent->data_values->button_text) }} </a>
            </div>
            <div class="col-lg-6 col-xl-7">
                <div class="ms-xxl-4">
                    <div class="section__img section__img--right">
                        <img src="{{ frontendImage('transfer', @$transferContent->data_values->image, '720x460') }}"
                            alt="transfer image" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
