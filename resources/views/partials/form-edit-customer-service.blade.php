<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title pt-1">{{ trans('language.service.title') }}</h3>
                    <div class="card-tools">
                        <a class="btn btn-success btn-sm btn-flat" id="plus_record">
                            <i class="fas fa-plus"></i>
                            {{ trans('language.service.add') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('customer.updateService', ['id' => $customer->id]) }}" method="post">
                        @csrf
                        <table class="table table-bordered" id="table_service">
                            <thead>
                            <tr>
                                <th class="text-center align-middle">#</th>
                                <th class="text-center align-middle w-15">
                                    {{ trans('language.service.title') }}
                                </th>
                                <th class="text-center align-middle">
                                    {{ trans('language.contract_date') }}
                                </th>
                                <th class="text-center align-middle">
                                    {{ trans('language.started_at') }}
                                </th>
                                <th class="text-center align-middle">
                                    {{ trans('language.ended_at') }}</th>
                                <th class="text-center align-middle">
                                    {{ trans('language.subtotal') }}
                                </th>
                                <th class="text-center align-middle w-15">
                                    {{ trans('language.customer.staff') }}
                                </th>
                                <th class="text-center align-middle w-10">
                                    {{ trans('language.type') }}
                                </th>
                                <th class="text-center align-middle">
                                    {{ trans('language.note') }}
                                </th>
                                <th>
                                </th>
                            </tr>
                            </thead>

                            <tbody>
                            @if (request()->old())
                                @for ($i = 0; $i < count(old('services', [])); $i++)
                                    <tr class="booking-box" data-booking-id="{{ $value->id }}">
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">
                                            <select class="form-control select2 service_change" name="services[]">
                                                <option value=" ">Dịch vụ</option>
                                                @foreach ($list_services as $item)
                                                    <option @if (old('services.' . $i) == $item->id) selected @endif
                                                    value="{{ $item->id }}">
                                                        {{ $item->service_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->first('services.' . $i))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('services.' . $i) }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <input name="contract_date[]" type="text"
                                                   value="{{ old('contract_date.' . $i) }}"
                                                   class="datepicker_start form-control text-center contractDateInput">
                                        </td>
                                        <td class="text-center">
                                            <input name="start[]" type="text"
                                                   class="datepicker_start started_date form-control text-center"
                                                   value="{{ old('start.' . $i) }}">
                                            @if ($errors->first('start.' . $i))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('start.' . $i) }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <input name="end[]" type="text"
                                                   class="datepicker_end ended_date form-control text-center"
                                                   value="{{ old('end.' . $i) }}">
                                            @if ($errors->first('end.' . $i))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('end.' . $i) }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="text-center align-middle">
                                            <input type="text" name="view_total[]"
                                                   class="form-control view-total"
                                                   value="{{ old('view_total.' . $i) }}">
                                            <input type="hidden" name="subtotal[]"
                                                   value="{{ old('subtotal.' . $i) }}">
                                            <input type="hidden" class="price_ser" name="price_ser[]"
                                                   value="{{ old('price_ser.' . $i) }}">
                                            @if ($errors->first('view_total.' . $i))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('view_total.' . $i) }}
                                                </div>
                                            @endif
                                        </td>

                                        <td>
                                            <select class="form-control select2" name="user_id[]">
                                                <option value=" "></option>
                                                @foreach ($staff as $item)
                                                    <option @if ($item->id == $value->user_id) selected @endif
                                                    value="{{ $item->id }}">
                                                        {{ $item->first_name }}
                                                        {{ $item->last_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->first('supplier.' . $i))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('supplier.' . $i) }}
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <select class="form-control select2 status-dell typeOrder"
                                                    name="typeCustomerService[]">
                                                <option selected disabled>--Chọn--</option>
                                                <option
                                                    value="1" {{ (collect(old('typeCustomerService.'.$i))->contains(1)) ? 'selected' : '' }}>
                                                    Giữ chỗ
                                                </option>
                                                <option
                                                    value="2" {{ (collect(old('typeCustomerService.'.$i))->contains(2)) ? 'selected' : '' }}>
                                                    Đã cọc
                                                </option>
                                                <option
                                                    value="3" {{ (collect(old('typeCustomerService.'.$i))->contains(3)) ? 'selected' : '' }}>
                                                    Đã thuê
                                                </option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="note[]" class="form-control"
                                                   value="{{ old('note.' . $i) }}">
                                            @if ($errors->first('note.' . $i))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('note.' . $i) }}
                                                </div>
                                            @endif
                                        </td>
                                        @if ($i == 0)
                                            <button style="border-radius:50%" type="button"
                                                    id="plus_record" class="btn btn-success btn-sm">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        @else
                                            <button style="border-radius:50%" type="button"
                                                    class="btn btn-danger btn-sm minus_record"><i
                                                    class="fas fa-minus"></i></button>
                                        @endif
                                    </tr>
                                @endfor
                            @else
                                @foreach ($services as $key => $value)
                                    <tr class="booking-box" data-booking-id="{{ $value->id }}">
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">
                                            <select class="form-control select2 service_change" name="services[]">
                                                <option selected="selected" value=" ">
                                                    Dịch vụ
                                                </option>
                                                @foreach ($list_services as $item)
                                                    <option @if ($item->id == $value->service_id) selected @endif
                                                    value="{{ $item->id }}">
                                                        {{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->first('services[]'))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('services[]') }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="d-flex justify-content-center align-items-center">
                                            <input name="contract_date[]"
                                                   value="{{ date('d/m/Y', strtotime($value->contract_date)) }}"
                                                   type="text"
                                                   class="datepicker_start form-control text-center contractDateInput"
                                                   style="display: table-cell;">
                                        </td>
                                        <td class="text-center">
                                            <input name="start[]" type="text"
                                                   class="datepicker_start started_date form-control text-center"
                                                   value="{{ date('d/m/Y', strtotime($value->started_at)) }}">
                                        </td>
                                        <td class="text-center">
                                            <input name="end[]" type="text"
                                                   class="datepicker_end ended_date form-control text-center"
                                                   value="{{ date('d/m/Y', strtotime($value->ended_at)) }}">
                                        </td>
                                        <td class="text-center align-middle">
                                            <input type="text" name="view_total[]"
                                                   class="form-control view-total"
                                                   value="{{ number_format($value->subtotal) }}">
                                            <input type="hidden" name="subtotal[]" value="">
                                            <input type="hidden" class="price_ser" name="price_ser[]"
                                                   value="{{ $value->price }}">
                                        </td>
                                        <td>
                                            <select class="form-control select2" name="user_id[]">
                                                <option selected="selected" value=" "></option>
                                                @foreach ($staff as $item)
                                                    <option @if ($item->id == $value->user_id) selected @endif
                                                    value="{{ $item->id }}">
                                                        {{ $item->first_name }}
                                                        {{ $item->last_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-control select2 status-dell typeOrder"
                                                    name="typeCustomerService[]">
                                                <option selected disabled>--Chọn--</option>
                                                <option value="1" {{ $value->type == 1 ? 'selected' : '' }}>Giữ chỗ
                                                </option>
                                                <option value="2" {{ $value->type == 2 ? 'selected' : '' }}>Đã cọc
                                                </option>
                                                <option value="3" {{ $value->type == 3 ? 'selected' : '' }}>Đã thuê
                                                </option>
                                                <option value="4" {{ $value->type == 4 ? 'selected' : '' }}>Đã hủy
                                                </option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="note[]" class="form-control"
                                                   value="{{ $value->note }}">
                                        </td>
                                        <td>
                                            <button style="border-radius:50%" type="button"
                                                    class="btn btn-danger btn-sm minus_record"><i
                                                    class="fas fa-minus"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end mt-2">
                            <button type="submit"
                                    data-url="{{ route('customer.checkDateAndTypeByService') }}"
                                    data-method="POST"
                                    data-id="{{ $customer->id }}"
                                    class="btn btn-primary btnSave"
                                    id="btnSave">{{ trans('language.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="d-none" id="clone_tr">
    <table>
        <tbody>
        <tr>
            <td class="text-center align-middle">1</td>
            <td class="text-center align-middle">
                <select class="form-control service_change services_id" name="services[]">
                    <option selected="selected" value=" ">Dịch vụ</option>
                    @foreach ($list_services as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->name }}
                        </option>
                    @endforeach
                </select>
            </td>
            <td class="d-flex justify-content-center align-items-center">
                <input name="contract_date[]" type="text"
                       class="datepicker_start form-control text-center contractDateInput">
            </td>
            <td class="text-center">
                <input name="start[]" type="text"
                       class="datepicker_start started_date form-control text-center">
            </td>
            <td class="text-center">
                <input name="end[]" type="text"
                       class="datepicker_end ended_date form-control text-center">
            </td>
            <td class="text-center align-middle">
                <input type="text" name="view_total[]" class="form-control view-total" value="">
                <input type="hidden" name="subtotal[]" value="">
                <input type="hidden" class="price_ser" name="price_ser[]" value="">
            </td>
            <td>
                <select class="form-control" name="user_id[]">
                    <option selected disabled>--Chọn--</option>
                    @foreach ($staff as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->first_name }}
                            {{ $item->last_name }}
                        </option>
                    @endforeach
                </select>
            </td>
            <td>
                <select class="form-control status-dell typeOrder" name="typeCustomerService[]">
                    <option selected disabled>--Chọn--</option>
                    <option value="1">Giữ chỗ</option>
                    <option value="2">Đã cọc</option>
                    <option value="3">Đã thuê</option>
                </select>
            </td>
            <td>
                <input type="text" name="note[]" class="form-control">
            </td>
            <td>
                <button style="border-radius:50%" type="button"
                        class="btn btn-danger btn-sm minus_record"><i
                        class="fas fa-minus"></i></button>
            </td>
        </tr>
        </tbody>
    </table>
</div>
