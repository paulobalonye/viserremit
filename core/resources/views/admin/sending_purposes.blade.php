@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th>@lang('S.N.')</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($sendingPurposes as $sendingPurpose)
                                    <tr>
                                        <td>{{ $sendingPurposes->firstItem() + $loop->index }}</td>
                                        <td>{{ $sendingPurpose->name }}</td>
                                        <td>
                                            @php echo $sendingPurpose->statusBadge; @endphp
                                        </td>
                                        <td>
                                            <div class="button--group">
                                                <button class="btn btn-sm btn-outline--primary cuModalBtn ml-1"
                                                    data-modal_title="@lang('Update Sending Purpose')"
                                                    data-resource="{{ $sendingPurpose }}">
                                                    <i class="las la-pen"></i>@lang('Edit')
                                                </button>
                                                @if ($sendingPurpose->status == Status::ENABLE)
                                                    <button class="btn btn-sm btn-outline--danger confirmationBtn"
                                                        data-question="@lang('Are you sure to enable this source of fund?')"
                                                        data-action="{{ route('admin.sending.purpose.status', $sendingPurpose->id) }}">
                                                        <i class="la la-eye-slash"></i> @lang('Disable')
                                                    </button>
                                                @else
                                                    <button class="btn btn-sm btn-outline--success confirmationBtn"
                                                        data-question="@lang('Are you sure to disable this source of fund?')"
                                                        data-action="{{ route('admin.sending.purpose.status', $sendingPurpose->id) }}">
                                                        <i class="la la-eye"></i> @lang('Disable')
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center">
                                            {{ __($emptyMessage) }}
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($sendingPurposes->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($sendingPurposes) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Save MODAL --}}
    <div id="cuModal" class="modal fade">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Edit Sending Purposes')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.sending.purpose.save') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Name') </label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                required />
                        </div>
                        <div class="status"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection
@push('breadcrumb-plugins')
    <x-search-form placeholder="Search name ..." />
    <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn" data-modal_title="@lang('Add New Sending Purpose')">
        <i class="las la-plus"></i>@lang('Add New')
    </button>
@endpush
