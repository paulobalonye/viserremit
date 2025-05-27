@extends('agent.layouts.app')

@section('panel')
    <div class="row justify-content-center mt-5">
        <div class="col-lg-8">
            <div class="border--card">
                <h4 class="title"><i class="las la-ticket-alt"></i> {{ __($pageTitle) }}</h4>
                <div class="card-body ">
                    <form action="{{ route('agent.ticket.store') }}" method="post" enctype="multipart/form-data"
                        onsubmit="return submitUserForm();">
                        @csrf
                        <input type="hidden" name="name" value="{{ @$user->firstname . ' ' . @$user->lastname }}">
                        <input type="hidden" name="email" value="{{ @$user->email }}">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="text--accent sm-text d-block mb-2 fw-md"
                                    for="website">@lang('Subject')</label>
                                <input type="text" name="subject" value="{{ old('subject') }}"
                                    class="form-control form--control ">
                            </div>
                            <div class="col-md-4">
                                <label class="text--accent sm-text d-block mb-2 fw-md"
                                    for="priority">@lang('Priority')</label>
                                <div class="form--select-light">
                                    <select name="priority" class="select form--select select2" data-minimum-results-for-search="-1">
                                        <option value="3">@lang('High')</option>
                                        <option value="2">@lang('Medium')</option>
                                        <option value="1">@lang('Low')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="text--accent sm-text d-block mb-2 fw-md"
                                    for="inputMessage">@lang('Message')</label>
                                <textarea name="message" id="inputMessage" rows="6" class="form--control " required>{{ old('message') }}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <button type="button" class="btn btn-dark btn-sm addAttachment my-2">
                                    <i class="fas fa-plus"></i> @lang('Add Attachment')
                                </button>
                                <p class="mb-2">
                                    <span class="text--info">
                                        @lang('Max 5 files can be uploaded | Maximum upload size is ' . convertToReadableSize(ini_get('upload_max_filesize')) . ' | Allowed File Extensions: .jpg, .jpeg, .png, .pdf, .doc, .docx')
                                    </span>
                                </p>
                                <div class="row fileUploadsContainer gy-3"></div>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn--base btn-sm w-100 my-2" type="submit"><i
                                        class="las la-paper-plane"></i>
                                    @lang('Submit')
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .input-group-text {
            color: #fff;
            border: unset;
        }

        .input-group-text:focus {
            box-shadow: none !important;
        }

        .form-control:focus{
            box-shadow: none !important;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            var fileAdded = 0;
            $('.addAttachment').on('click', function() {
                fileAdded++;
                if (fileAdded == 5) {
                    $(this).attr('disabled', true)
                }
                $(".fileUploadsContainer").append(`
                    <div class="col-lg-4 col-md-12 removeFileInput">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="file" name="attachments[]" class="form-control" accept=".jpeg,.jpg,.png,.pdf,.doc,.docx" required>
                                <button type="button" class="input-group-text removeFile bg--danger border--danger"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                    </div>
                `)
            });
            $(document).on('click', '.removeFile', function() {
                $('.addAttachment').removeAttr('disabled', true)
                fileAdded--;
                $(this).closest('.removeFileInput').remove();
            });
        })(jQuery);
    </script>
@endpush
