@if (gs('multi_language'))
    @php
        $language = App\Models\Language::all();
        $activeLanguage = $language->where('code', config('app.locale'))->first();
    @endphp
    <div class="custom--dropdown ms-3">
        <div class="custom--dropdown__selected dropdown-list__item">
            <div>
                <div class="thumb">
                    <img src="{{ getImage(getFilePath('language') . '/' . @$activeLanguage->image, getFileSize('language')) }}"
                        alt="image">
                </div>
            </div>
            <span class="text">{{ __(@$activeLanguage->name) }}</span>
            <span class="icon"><i class="fas fa-angle-down"></i></span>

        </div>
        <ul class="dropdown-list">
            @foreach ($language as $item)
                @if (@$item->id != @$activeLanguage->id)
                    <li class="dropdown-list__item langSel" data-value="{{ $item->code }}">
                        <div>
                            <div class="thumb">
                                <img src="{{ getImage(getFilePath('language') . '/' . @$item->image, getFileSize('language')) }}"
                                    alt="image">
                            </div>
                        </div>
                        <span class="text">{{ __($item->name) }}</span>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
@endif

@push('script')
    <script>
        (function($) {
            'use strict'

            // language ----------------
            $('.custom--dropdown__selected').on('click', function() {
                $(this).parent().toggleClass('open');
            });

            $(document).on('keyup', function(evt) {
                if ((evt.keyCode || evt.which) === 27) {
                    $('.custom--dropdown').removeClass('open');
                }
            });

            $(document).on('click', function(evt) {
                if ($(evt.target).closest(".custom--dropdown > .custom--dropdown__selected").length === 0) {
                    $('.custom--dropdown').removeClass('open');
                }
            });

            $(".langSel").on("click", function() {
                window.location.href = "{{ route('home') }}/change/" + $(this).data('value');
            });
        })(jQuery)
    </script>
@endpush
@push('style')
    <style>
        /* language */
        .custom--dropdown {
            position: relative;
            display: inline-block;
        }

        .custom--dropdown>.custom--dropdown__selected {
            background-color: transparent;
            cursor: pointer;
            font-size: 14px;
            padding-right: 20px;
        }

        @media screen and (max-width: 1399px) {
            .custom--dropdown>.custom--dropdown__selected {
                padding-right: 15px;
            }
        }

        .custom--dropdown>.dropdown-list {
            position: absolute;
            width: 100%;
            border-radius: 3px;
            opacity: 0;
            overflow: hidden;
            transition: 0.25s ease-in-out;
            -webkit-transform-origin: top center;
            transform-origin: top center;
            top: 100%;
            margin-top: 5px;
            z-index: -1;
            visibility: hidden;
            max-height: 230px;
            overflow-y: auto !important;
            padding-left: 0 !important;
            flex-direction: column;
        }

        .custom--dropdown>.dropdown-list::-webkit-scrollbar {
            width: 4px;
            height: 4px;
        }

        .custom--dropdown.open>.dropdown-list {
            opacity: 1;
            visibility: visible;
            z-index: 999 !important;
            min-width: 120px;
            background-color: #fff;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        .dropdown-list>.dropdown-list__item {
            padding: 8px !important;
            cursor: pointer;
            -webkit-transition: 0.3s;
            transition: 0.3s;
            font-size: 14px;
            font-weight: 500 !important;
            border-radius: 5px;
            min-width: 120px;
        }

        .dropdown-list>.dropdown-list__item:hover {
            background-color: rgb(var(--r), var(--g), var(--b)) !important;
        }

        .dropdown-list>.dropdown-list__item:hover span {
            color: #fff !important;
        }

        .dropdown-list>.dropdown-list__item,
        .custom--dropdown>.custom--dropdown__selected {
            display: flex;
            align-items: center;
            gap: 10px
        }

        .dropdown-list>.dropdown-list__item .thumb img,
        .custom--dropdown>.custom--dropdown__selected .thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover !important;
        }

        .dropdown-list>.dropdown-list__item .thumb,
        .custom--dropdown>.custom--dropdown__selected .thumb {
            width: 25px;
            height: 25px;
            border-radius: 50%;
            overflow: hidden;
        }

        .dropdown-list>.dropdown-list__item .text {
            width: 100%;
            color: #000 !important;
        }

        .custom--dropdown>.custom--dropdown__selected .text {
            width: 100%;
            color: #fff !important;
            font-weight: 500 !important;
        }

        .fixed-header .custom--dropdown>.custom--dropdown__selected .text {
            color: #000 !important;
        }

        .dropdown-list__item .icon {
            color: #fff;
        }
        .fixed-header .dropdown-list__item .icon {
            color: #000;
        }

        .custom--dropdown .dropdown-list {
            top: calc(100% + 5px);
        }

        .side-menu--open~.sidebar-submenu {
            display: block;
        }
        .header--secondary .custom--dropdown>.custom--dropdown__selected .text {
            color: #000 !important;
        }
        .header--secondary .dropdown-list__item .icon {
            color: #000 !important;
        }
        .custom--dropdown.open .dropdown-list__item .icon i {
            transform: rotate(180deg);
        }
        /* language */
    </style>
@endpush
