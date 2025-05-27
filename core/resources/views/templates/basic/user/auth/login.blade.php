@extends($activeTemplate . 'layouts.frontend')
@php
    $loginContent = getContent('login.content', true);
@endphp
@section('content')
    <div class="section login-section"
        style="background-image: url({{ getImage($activeTemplateTrue . 'images/auth-bg.jpg') }})">
        <div class="container">
            <div class="row g-4 g-lg-0 justify-content-between align-items-center">
                <div class="col-lg-6 d-none d-lg-block">
                    <img src="{{ frontendImage('login', @$loginContent->data_values->image, '660x625') }}" alt="login image"
                        class="img-fluid">
                </div>
                <div class="col-lg-5">
                    @include($activeTemplate . 'user.auth.login_form')
                </div>
            </div>
        </div>
    </div>
@endsection
