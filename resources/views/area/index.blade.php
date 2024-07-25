@extends('layout.master')

@section('css')
@endsection

@section('content')
    @include('partials.breadcrumb', [
        'title' => trans('language.area.title'),
        'current_page' => trans('language.area.title'),
    ])

    <section class="content">
        <div class="container-fluid pb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-success mr-2" data-toggle="collapse" href="#collapseExample"
                            aria-expanded="false" aria-controls="collapseExample"><i class="fas fa-filter"></i></button>
                        <a href="{{ route('area.create') }}" type="button" class="btn btn-info">
                            <i class="fas fa-plus"></i>{{ trans('language.area.add') }}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="collapse {{ optional(request())->hasAny(['name', 'email', 'phone', 'code', 'tax_code', 'career']) ? 'show' : '' }}"
                            id="collapseExample">
                            <form action="{{ route('area.index') }}" method="get">
                                <div class="card-header">
                                    <div class="col-md-12 d-flex">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{ trans('language.area.name') }}</label>
                                                <input type="text" class="form-control form-control-sm" name="name"
                                                    value="{{ request()->name ?? '' }}"
                                                    placeholder="{{ trans('language.area.name') }}">
                                            </div>
                                        </div>
                                        <div class="mr-2">
                                            <div class="form-group d-flex flex-column">
                                                <label>&nbsp;</label>
                                                <button type="submit" class="btn btn-success btn-sm"><i
                                                        class="fas fa-search"></i>{{ trans('language.search') }}</button>
                                            </div>
                                        </div>
                                        <div class="">
                                            <div class="form-group d-flex flex-column">
                                                <label>&nbsp;</label>
                                                <a href="{{ route('area.index') }}" class="btn btn-success btn-sm"><i
                                                        class="fas fa-sync-alt"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">{{ trans('language.area.name') }}</th>
                                        <th class="text-center">{{ trans('language.area.slug') }}</th>
                                        <th class="text-center">{{ trans('language.area.active') }}</th>
                                        <th class="text-center">{{ trans('language.area.hot') }}</th>
                                        <th class="text-center">{{ trans('language.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($areas->count() > 0)
                                        @foreach ($areas as $key => $item)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $key + 1 + ($areas->currentPage() - 1) * $areas->perPage() }}
                                                </td>
                                                <td>{{ $item->name }}</td>
                                                <td class="text-center">{{ $item->slug }}</td>
                                                <td class="text-center">
                                                    <button
                                                        class="toggle-active-btn btn {{ $item->active == 1 ? 'btn-success' : 'btn-danger' }} text-white"
                                                        data-id="{{ $item->id }}" data-status="{{ $item->active }}"
                                                        data-url="{{ route('area.changeActive') }}">
                                                        {{ $item->active == 1 ? 'Hiển thị' : 'Ẩn' }}
                                                    </button>
                                                </td>
                                                <td class="text-center">
                                                    <button
                                                        class="toggle-hot-btn btn {{ $item->hot == 1 ? 'btn-success' : 'btn-danger' }} text-white"
                                                        data-id="{{ $item->id }}" data-status="{{ $item->hot }}"
                                                        data-url="{{ route('area.changeHot') }}">
                                                        {{ $item->hot == 1 ? 'Nổi bật' : 'Ẩn' }}
                                                    </button>
                                                </td>
                                                <td class="text-center">
                                                    <div class="flex justify-center items-center">
                                                        <a class="flex items-center mr-3"
                                                            href="{{ route('area.edit', ['id' => $item->id]) }}">
                                                            <i class="fas fa-edit"></i>
                                                            {{ trans('language.edit') }}
                                                        </a>
                                                        <a href="javascript:void(0)"
                                                            class="flex items-center text-danger deleteTable"
                                                            data-id="{{ $item->id }}"
                                                            data-title="{{ trans('message.confirm_delete_area') }}"
                                                            data-text="<span >{{ $item->name }}</span>"
                                                            data-url="{{ route('area.delete', ['id' => $item->id]) }}"
                                                            data-method="DELETE" data-icon="question">
                                                            <i class="fas fa-trash-alt"></i>
                                                            {{ trans('language.delete') }}
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="9" class="text-center"> {{ trans('language.no-data') }} </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div>
                                <div class="text-center">
                                    {{ $areas->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    {{-- <script>
        $(document).ready(function() {
            $('.toggle-active-btn').click(function() {
                var button = $(this); // The button that was clicked
                var itemId = button.data('id'); // The item ID
                var currentStatus = button.data('status'); // The current active status

                $.ajax({
                    url: "{{ route('area.changeActive') }}", // Your route here
                    type: 'POST',
                    data: {
                        id: itemId,
                        _token: '{{ csrf_token() }}', // CSRF token for Laravel
                    },
                    success: function(response) {
                        // Assuming the response contains the new status
                        button.data('status', response.newStatus);

                        // Update button text
                        var buttonText = response.newStatus == 1 ? 'Hiển thị' :
                            'Ẩn';
                        button.text(buttonText);

                        // Remove existing classes and add new ones based on the new status
                        button.removeClass('btn-success btn-danger');
                        var buttonClass = response.newStatus == 1 ? 'btn-success' :
                        'btn-danger';
                        button.addClass(buttonClass);

                        // Using SweetAlert to show a success message
                        Swal.fire({
                            title: 'Thành công!',
                            text: 'Cập nhật trạng thái thành công!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });

        $(document).ready(function() {
            $('.toggle-hot-btn').click(function() {
                var button = $(this); // The button that was clicked
                var itemId = button.data('id'); // The item ID
                var currentStatus = button.data('status'); // The current active status

                $.ajax({
                    url: "{{ route('area.changeHot') }}", // Your route here
                    type: 'POST',
                    data: {
                        id: itemId,
                        _token: '{{ csrf_token() }}', // CSRF token for Laravel
                    },
                    success: function(response) {
                        // Assuming the response contains the new status
                        button.data('status', response.newHot);

                        // Update button text
                        var buttonText = response.newHot == 1 ? 'Nổi bật' :
                            'Ẩn';
                        button.text(buttonText);

                        // Remove existing classes and add new ones based on the new status
                        button.removeClass('btn-success btn-danger');
                        var buttonClass = response.newHot == 1 ? 'btn-success' :
                        'btn-danger';
                        button.addClass(buttonClass);

                        // Using SweetAlert to show a success message
                        Swal.fire({
                            title: 'Thành công!',
                            text: 'Cập nhật trạng thái thành công!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
    </script> --}}
    <script src="{{ asset('dist/js/pages/area.js') }}"></script>
@endsection