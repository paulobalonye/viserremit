<ul class="nav nav-tabs mb-4 topTap breadcrumb-nav" role="tablist">
    <button class="breadcrumb-nav-close"><i class="las la-times"></i></button>
    <li class="nav-item {{ menuActive('admin.kyc.setting.user') }}" role="presentation">
        <a href="{{ route('admin.kyc.setting.user') }}" class="nav-link text-dark" type="button">
            <i class="far fa-user"></i> @lang('Personal user')
        </a>
    </li>
    <li class="nav-item {{ menuActive('admin.kyc.setting.user.business') }}" role="presentation">
        <a href="{{ route('admin.kyc.setting.user.business') }}" class="nav-link text-dark" type="button">
            <i class="fas fa-user-tie"></i> @lang('Business User')
        </a>
    </li>
    <li class="nav-item {{ menuActive('admin.kyc.setting.agent') }}" role="presentation">
        <a href="{{ route('admin.kyc.setting.agent') }}" class="nav-link text-dark" type="button">
            <i class="fas fa-user-tag"></i> @lang('Agent')
        </a>
    </li>
    <li class="nav-item {{ menuActive('admin.kyc.setting.module') }}" role="presentation">
        <a href="{{ route('admin.kyc.setting.module') }}" class="nav-link text-dark" type="button">
            <i class="fab fa-modx"></i> @lang('KYC Modules')
        </a>
    </li>
</ul>
