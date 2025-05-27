@php
    $chooseUsContent = getContent('choose_us.content', true);
    $chooseUsElements = getContent('choose_us.element', false, null, true);
@endphp
<div class="section--bottom">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-lg-6 order-lg-1 order-2">
                <div class="section__img section__img--left">
                    <img src="{{ frontendImage('choose_us', @$chooseUsContent->data_values->image, '635x455') }}"
                        alt="choose us image" class="img-fluid" />
                </div>
            </div>
            <div class="col-lg-6 order-lg-2 order-1">
                <div class="ms-xxl-4">
                    <h3 class="mt-0">{{ __(@$chooseUsContent->data_values->heading) }}</h3>
                    <ul class="list list--column icon-list">
                        @foreach (@$chooseUsElements ?? [] as $chooseUsElement)
                            <li class="list__item icon-list__item">
                                <div class="icon-list__box">
                                    <div class="icon icon--circle icon--xl bg--base text--white flex-shrink-0">
                                        @php
                                            echo $chooseUsElement->data_values->icon;
                                        @endphp
                                    </div>
                                    <div class="icon-list__content">
                                        <h5 class="mt-0">
                                            {{ __($chooseUsElement->data_values->title) }}
                                        </h5>
                                        <p class="icon-list__para mb-0">
                                            {{ __($chooseUsElement->data_values->description) }}
                                        </p>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
