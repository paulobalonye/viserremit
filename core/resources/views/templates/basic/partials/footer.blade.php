@php
    $contactContent = getContent('contact.content', true);
    $appContent = getContent('app.content', true);
    $policyPages = getContent('policy_pages.element', false, null, true);
@endphp
<footer class="footer bg--accent">
    <div class="section">
        <div class="container">
            <div class="row g-4 gy-sm-5 justify-content-xl-between">
                <div class="col-sm-6 col-lg-4 col-xxl-3">
                    <h5 class="text--white widget__title mt-0">@lang('About Company')</h5>
                    <p class="text--white t-short-para mb-0">
                        {{ __(@$appContent->data_values->short_description) }}
                    </p>

                </div>
                <div class="col-sm-6 col-lg-2 col-xl-2">
                    <h5 class="text--white widget__title mt-0">@lang('Accounts')</h5>
                    <ul class="list list--column list--base">
                        <li class="list--column__item">
                            <a href="{{ route('user.login') }}" class="t-link t-link--base text--white d-inline-block">
                                @lang('Login')
                            </a>
                        </li>
                        <li class="list--column__item">
                            <a href="{{ route('user.register') }}"
                                class="t-link t-link--base text--white d-inline-block">
                                @lang('Register')
                            </a>
                        </li>
                        <li class="list--column__item">
                            <a href="{{ route('agent.login') }}" class="t-link t-link--base text--white d-inline-block">
                                @lang('Agent Login')
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-6 col-lg-3 col-xl-2">
                    <h5 class="text--white widget__title mt-0">@lang('Policy Pages')</h5>
                    <ul class="list list--column list--base">
                        @foreach (@$policyPages ?? [] as $page)
                            <li class="list--column__item">
                                <a href="{{ route('policy.pages', $page->slug) }}"
                                    class="t-link t-link--base text--white d-inline-block">
                                    {{ __($page->data_values->title) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-sm-6 col-lg-3 col-xl-4 col-xxl-3">
                    <h5 class="text--white widget__title mt-0">
                        @lang('Contact Us')
                    </h5>
                    <ul class="list list--column">
                        <li class="list--column__item">
                            <div class="contact-card">
                                <div class="contact-card__icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="contact-card__content">
                                    <p class="text--white mb-0">
                                        {{ __(@$contactContent->data_values->address) }}
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="list--column__item">
                            <div class="contact-card">
                                <div class="contact-card__icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="contact-card__content">
                                    <a href="Mailto:{{ @$contactContent->data_values->email }}" class="text-decoration-none">
                                        <p class="text--white mb-0">
                                            {{ __(@$contactContent->data_values->email) }}
                                        </p>
                                    </a>
                                </div>
                            </div>
                        </li>
                        <li class="list--column__item">
                            <div class="contact-card">
                                <div class="contact-card__icon">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <div class="contact-card__content">
                                    <a href="Tel:{{ @$contactContent->data_values->mobile }}" class="text-decoration-none">
                                        <p class="text--white mb-0">
                                            {{ __(@$contactContent->data_values->mobile) }}
                                        </p>
                                    </a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-copyright bg--accent-dark py-3">
        <p class="sm-text text--white mb-0 text-center">@lang('Copyright') &copy; {{ __(date('Y')) }}. @lang('All Rights Reserved')
        </p>
    </div>
</footer>
