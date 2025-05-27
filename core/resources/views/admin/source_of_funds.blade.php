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
                                @forelse ($sourceOfFunds as $sourceOfFund)
                                    <tr>
                                        <td>{{ $sourceOfFunds->firstItem() + $loop->index }}</td>
                                        <td>{{ $sourceOfFund->name }}</td>
                                        <td> @php echo $sourceOfFund->statusBadge; @endphp</td>
                                        <td>
                                            <div class="button--group">
                                                <button class="btn btn-sm btn-outline--primary cuModalBtn ml-1"
                                                    data-modal_title="@lang('Update Source of Fund')" data-resource="{{ $sourceOfFund }}">
                                                    <i class="las la-pen"></i>@lang('Edit')
                                                </button>
                                                @if ($sourceOfFund->status == Status::ENABLE)
                                                    <button class="btn btn-sm btn-outline--danger confirmationBtn"
                                                        data-question="@lang('Are you sure to enable this source of fund?')"
                                                        data-action="{{ route('admin.sof.status', $sourceOfFund->id) }}">
                                                        <i class="la la-eye-slash"></i> @lang('Disable')
                                                    </button>
                                                @else
                                                    <button class="btn btn-sm btn-outline--success confirmationBtn"
                                                        data-question="@lang('Are you sure to disable this source of fund?')"
                                                        data-action="{{ route('admin.sof.status', $sourceOfFund->id) }}">
                                                        <i class="la la-eye"></i> @lang('Disable')
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($sourceOfFunds->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($sourceOfFunds) }}
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
                    <h5 class="modal-title">@lang('Edit Sending Purpose')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.sof.save') }}" method="POST">
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
                        <button type="submit" class="btn btn--primary h-45 w-100">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <x-search-form placeholder="Search source of fund ..." />
    <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn" data-modal_title="@lang('Add New Source of Fund')">
        <i class="las la-plus"></i>@lang('Add New')
    </button>
@endpush
