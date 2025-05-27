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
                                    <th>@lang('Method Name')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($deliveryMethods as $deliveryMethod)
                                    <tr>
                                        <td>{{ $deliveryMethods->firstItem() + $loop->index }}</td>
                                        <td>{{ __($deliveryMethod->name) }}</td>
                                        <td>@php echo $deliveryMethod->statusBadge; @endphp </td>
                                        <td>
                                            <div class="button--group">
                                                <button class="btn btn-sm btn-outline--primary cuModalBtn"
                                                    data-modal_title="@lang('Update Delivery Method')" data-resource="{{ $deliveryMethod }}"
                                                    data-has_status="1">
                                                    <i class="las la-pen"></i>
                                                    @lang('Edit')
                                                </button>
                                                @if ($deliveryMethod->status == Status::ENABLE)
                                                    <button class="btn btn-sm btn-outline--danger confirmationBtn"
                                                        data-question="@lang('Are you sure to enable this delivery method?')"
                                                        data-action="{{ route('admin.delivery.method.status', $deliveryMethod->id) }}"><i
                                                            class="la la-eye-slash"></i> @lang('Disable')</button>
                                                @else
                                                    <button class="btn btn-sm btn-outline--success confirmationBtn"
                                                        data-question="@lang('Are you sure to disable this delivery method?')"
                                                        data-action="{{ route('admin.delivery.method.status', $deliveryMethod->id) }}"><i
                                                            class="la la-eye"></i> @lang('Disable')</button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($deliveryMethods->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($deliveryMethods) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ADD METHOD MODAL --}}
    <div class="modal fade" id="cuModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.delivery.method.store') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Method Name') </label>
                            <input class="form-control" name="name" type="text" value="{{ old('name') }}" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn--primary w-100 h-45" type="submit">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <x-search-form placeholder="Search method ..." />
    <button class="btn btn-sm btn-outline--primary cuModalBtn" data-modal_title="@lang('Add New Method')" type="button">
        <i class="las la-plus"></i>@lang('Add New')
    </button>
@endpush
