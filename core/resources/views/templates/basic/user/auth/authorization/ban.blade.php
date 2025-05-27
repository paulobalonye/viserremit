@extends($activeTemplate . 'layouts.app')
@php
    $bannedContent = getContent('banned_section.content', true);
@endphp
@section('panel')
    <div class="section login-section flex-column justify-content-center">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-7 text-center">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <img src="{{ frontendImage('banned_section', @$bannedContent->data_values->image) }}" alt="banned image">
                        </div>
                        <div class="col-xl-10">
                            <h5 class="text--danger">{{ __(@$bannedContent->data_values->heading) }}</h5>
                        </div>
                    </div>
                    <p class="text-center mx-auto">{{ __($user->ban_reason) }} </p>
                    <a href="{{ route('home') }}" class="btn btn--base"> @lang('Go to Home') </a>
                </div>
            </div>
        </div>
    </div>
@endsection
