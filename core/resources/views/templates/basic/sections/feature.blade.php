@php
    $featureContent = getContent('feature.content', true);
    $featureElements = getContent('feature.element', false, null, true);
@endphp
<div class="section features-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h3 class="mt-0 mb-4 text-center">
                    {{ __(@$featureContent->data_values->heading) }}
                </h3>
            </div>
        </div>
        <div class="row g-4 g-md-3 justify-content-center">
            @foreach (@$featureElements ?? [] as $featureElement)
                <div class="col-md-4">
                    <div
                        class="features-card flex-column flex-xl-row justify-content-center text-xl-start align-items-xl-center text-center">
                        <div class="icon icon--circle icon--xl bg--base text--white mx-auto flex-shrink-0">
                            @php
                                echo $featureElement->data_values->icon;
                            @endphp
                        </div>
                        <div class="features-card__content">
                            <h5 class="mt-0 mb-2">
                                {{ __($featureElement->data_values->title) }}
                            </h5>
                            <p class="mb-0">
                                {{ __($featureElement->data_values->description) }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
