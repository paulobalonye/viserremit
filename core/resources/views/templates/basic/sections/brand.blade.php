@php
    $brandElements = getContent('brand.element', false, null, true);
@endphp
<div class="section--sm section--bottom">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="client-slider">
                    @foreach ($brandElements ?? [] as $brandElement)
                        <div class="client-slider__item">
                            <div class="client-card">
                                <img src={{ frontendImage('brand', @$brandElement->data_values->image, '130x50') }}
                                    alt="brand image" class="client-card__img">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
