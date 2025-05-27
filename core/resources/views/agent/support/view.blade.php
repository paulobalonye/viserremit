@extends('agent.layouts.app')

@section('panel')
    <div class="row justify-content-center mt-5">
        <div class="col-lg-8">
            <div class="border--card h-auto">
                <div class="card-hseader card-header-bg d-flex flex-wrap justify-content-between align-items-center mb-4">
                    <h4 class="title m-0">
                        @php echo $myTicket->statusBadge; @endphp
                        [@lang('Ticket')#{{ $myTicket->ticket }}] {{ $myTicket->subject }}
                    </h4>
                    @if ($myTicket->status != Status::TICKET_CLOSE && $myTicket->agent)
                        <button class="btn btn-danger close-button btn-sm closeButton" data-bs-target="#closeModal"
                            data-bs-toggle="modal" type="button"><i class="fa fa-lg fa-times-circle"></i>
                        </button>
                    @endif
                </div>
                <div class="card-body ">
                    <form action="{{ route('ticket.reply', $myTicket->id) }}" enctype="multipart/form-data" method="post" class="disableSubmission">
                        @csrf
                        <div class="row justify-content-between">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea class="form--control" name="message" rows="4">{{ old('message') }}</textarea>
                                </div>
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
                                <div class="row fileUploadsContainer"></div>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn--base btn-sm w-100 my-2" type="submit">
                                    <i class="la la-fw la-lg la-reply"></i>
                                    @lang('Reply')
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="border--card mt-4 h-auto">
                <div class="card-body">
                    @foreach ($messages as $message)
                        @if ($message->admin_id == 0)
                            <div class="row border border-primary border-radius-3 my-3 py-3 mx-2">
                                <div class="col-md-3 border-end text-end">
                                    <h5 class="my-3">{{ $message->ticket->name }}</h5>
                                </div>
                                <div class="col-md-9">
                                    <p class="text-muted fw-bold my-3">
                                        @lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }}</p>
                                    <p>{{ $message->message }}</p>
                                    @if ($message->attachments->count() > 0)
                                        <div class="mt-2">
                                            @foreach ($message->attachments as $k => $image)
                                                <a class="mr-3"
                                                    href="{{ route('ticket.download', encrypt($image->id)) }}"><i
                                                        class="fa fa-file"></i> @lang('Attachment') {{ ++$k }} </a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="row border border-warning border-radius-3 my-3 py-3 mx-2"
                                style="background-color: #ffd96729">
                                <div class="col-md-3 border-end text-end">
                                    <h5 class="my-3">{{ $message->admin->name }}</h5>
                                    <p class="lead text-muted">@lang('Staff')</p>
                                </div>
                                <div class="col-md-9">
                                    <p class="text-muted fw-bold my-3">
                                        @lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }}</p>
                                    <p>{{ $message->message }}</p>
                                    @if ($message->attachments->count() > 0)
                                        <div class="mt-2">
                                            @foreach ($message->attachments as $k => $image)
                                                <a class="mr-3"
                                                    href="{{ route('ticket.download', encrypt($image->id)) }}"><i
                                                        class="fa fa-file"></i> @lang('Attachment') {{ ++$k }} </a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    <div class="modal custom--modal fade" id="closeModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('ticket.close', $myTicket->id) }}" method="POST" class="disableSubmission">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('Confirmation Alert!')</h5>
                    </div>
                    <div class="modal-body">
                        @lang('Are you sure to close this ticket?')
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn--danger btn-sm" data-bs-dismiss="modal" type="button">@lang('No')</button>
                        <button class="btn btn--base btn-sm" type="submit">@lang('Yes')</button>
                    </div>
                </form>
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
