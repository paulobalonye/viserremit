<form action="{{ route('user.login') }}" id="loginForm" class="login__form row verify-gcaptcha disableSubmission"
    autocomplete="off" method="POST">
    @csrf
    <div class="col-12">
        <div class="mb-3">
            <label for="username" class="form-label sm-text t-heading-font heading-clr fw-md"> @lang('Username or Email')</label>
            <input type="text" id="userEmail" name="username" value="{{ old('username') }}"
                class="form-control form--control" required>
        </div>
    </div>
    <div class="col-12">
        <div class="mb-3">
            <label for="userPass" class="form-label sm-text t-heading-font heading-clr fw-md">
                @lang('Password')</label>
            <div class="input-group">
                <input id="userPass" type="password" name="password" class="form-control form--control border-end-0" />
                <span class="input-group-text pass-toggle border-start-0">
                    <i class="las la-eye-slash"></i>
                </span>
            </div>
        </div>
    </div>
    <x-captcha class="sm-text t-heading-font heading-clr fw-md" />
    <div class="col-12 mb-3">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="form-check flex-shrink-0">
                <input class="form-check-input custom--check" type="checkbox" name="remember"
                    {{ old('remember') ? 'checked' : '' }} id="rememberMe" />
                <label class="form-check-label sm-text t-heading-font heading-clr fw-md" for="rememberMe">
                    @lang('Remember Me') </label>
            </div>
            <a href="{{ route('user.password.request') }}"
                class="d-block text-md-end t-link--base heading-clr sm-text flex-shrink-0"> @lang('Forgot your password?')
            </a>
        </div>
    </div>
    <div class="col-12">
        <button class="btn btn--xl btn--base w-100 btn--xl"> @lang('LOGIN ACCOUNT') </button>
    </div>
    <div class="col-12 mt-3">
        <div class="d-flex justify-content-center align-items-center gap-2">
            <span class="d-inline-block">
                @lang('Don\'t have any account?')
            </span>
            <a href="{{ route('user.register') }}"
                class="t-link d-inline-block text-end t-link--base base-clr sm-text lh-1 text-center"> @lang('Create One')
            </a>
        </div>
    </div>
</form>
