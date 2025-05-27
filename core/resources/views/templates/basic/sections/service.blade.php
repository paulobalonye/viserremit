@php
    $serviceContent = getContent('service.content', true);
@endphp
<div class="section">
    <div class="container">
        <div class="row gy-5 g-lg-4">
            <div class="col-lg-6">
                <div class="me-xxl-5">
                    <h3 class="mt-0">{{ __(@$serviceContent->data_values->heading) }}</h3>
                    <p class="mb-0">
                        @php
                            echo @$serviceContent->data_values->description_one;
                        @endphp
                    </p>
                    <br>
                    <p class="mb-0">
                        @php
                            echo @$serviceContent->data_values->description_two;
                        @endphp
                    </p>
                    <a href="{{ $serviceContent->data_values->button_link ?? '' }}" class="btn btn--xl btn--base mt-3">
                        {{ __(@$serviceContent->data_values->button_text) }} </a>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block">
                <img src="{{ frontendImage('service', @$serviceContent->data_values->image, '630x630') }}"
                    alt="service image" class="img-fluid" />
            </div>
        </div>
    </div>
</div>
