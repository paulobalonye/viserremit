@php
    $appContent = getContent('app.content', true);
    $appElements = getContent('app.element', false, null, true);
@endphp
<div class="section--top">
    <div class="container">
        <div class="row gy-5 g-lg-4 align-items-center justify-content-center">
            <div class="col-lg-6 col-md-5 col-sm-10">
                <img src="{{ frontendImage('app', @$appContent->data_values->image, '630x635') }}"
                    alt="{{ gs('site_name') }}" class="img-fluid">
            </div>
            <div class="col-lg-6 col-md-7">
                <div class="ms-xxl-5">
                    <h3 class="mt-0">
                        {{ __(@$appContent->data_values->heading) }}
                    </h3>
                    <p class="section__para">
                        {{ __(@$appContent->data_values->short_description) }}
                    </p>
                    <ul class="list list--column list--base">
                        @foreach (@$appElements ?? [] as $appElement)
                            <li class="list--column__item">
                                {{ __($appElement->data_values->key_feature_item) }}
                            </li>
                        @endforeach
                    </ul>
                    <div class="hero__btn-group flex-lg-wrap gap-sm-4 mt-4 flex-nowrap gap-3">
                        <a target="_blank" href="{{ $appContent->data_values->play_store_url ?? '' }}"
                            class="t-link d-inline-block">
                            <img src="{{ frontendImage('app', @$appContent->data_values->play_store_icon, '200x60') }}"
                                alt="remittance" class="img-fluid">
                        </a>
                        <a target="_blank" href="{{ $appContent->data_values->app_store_url ?? '' }}"
                            class="t-link d-inline-block">
                            <img src="{{ frontendImage('app', @$appContent->data_values->app_store_icon, '200x60') }}"
                                alt="remittance" class="img-fluid">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
