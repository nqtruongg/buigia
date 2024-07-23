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
                                    <th class="text-center align-middle w-20">
                                        {{ trans('language.service.title') }}
                                    </th>
                                    <th class="text-center align-middle">
                                        {{ trans('language.time') }}
                                    </th>
                                    <th class="text-center align-middle">
                                        {{ trans('language.started_at') }}
                                    </th>
                                    <th class="text-center align-middle">
                                        {{ trans('language.ended_at') }}</th>
                                    <th class="text-center align-middle">
                                        {{ trans('language.subtotal') }}
                                    </th>
                                    <th class="text-center align-middle">
                                        {{ trans('language.customer.supplier') }}
                                    </th>
                                    <th class="text-center align-middle">
                                        {{ trans('language.note') }}
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @if (request()->old())
                                    @for ($i = 0; $i < count(old('services', [])); $i++)
                                        <tr>
                                            <td class="text-center align-middle">1</td>
                                            <td class="text-center align-middle">
                                                <select class="form-control select2 service_change" name="services[]">
                                                    <option value=" ">Dịch vụ</option>
                                                    @foreach ($services as $item)
                                                        <option @if (old('services.' . $i) == $item->id) selected @endif
                                                            value="{{ $item->id }}">
                                                            {{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->first('services.' . $i))
                                                    <div class="invalid-alert text-danger">
                                                        {{ $errors->first('services.' . $i) }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="d-flex justify-content-center align-items-center">
                                                <input name="time_view[]"
                                                    class="form-control form-control-border number-hidden-input text-center input-time"
                                                    type="number" min="1" max="10000"
                                                    value="{{ old('time.' . $i) }}"
                                                    @if (old('time.' . $i) == null) disabled @endif>
                                                <input type="hidden" name="time[]" value="{{ old('time.' . $i) }}">
                                                @if ($errors->first('time.' . $i))
                                                    <div class="invalid-alert text-danger">
                                                        {{ $errors->first('time.' . $i) }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <input name="start[]" type="text"
                                                    class="datepicker_start form-control text-center"
                                                    value="{{ old('start.' . $i) }}">
                                                @if ($errors->first('start.' . $i))
                                                    <div class="invalid-alert text-danger">
                                                        {{ $errors->first('start.' . $i) }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <input name="end[]" type="text"
                                                    class="datepicker_end form-control text-center"
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
                                                <select class="form-control select2" name="supplier[]">
                                                    <option value=" "></option>
                                                    @foreach ($suppliers as $item)
                                                        <option
                                                            @if (old('supplier.' . $i) == $item->id) selected @endif
                                                            value="{{ $item->id }}">
                                                            {{ $item->name }}
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
                                                <input type="text" name="note[]" class="form-control"
                                                    value="{{ old('note.' . $i) }}">
                                                @if ($errors->first('note.' . $i))
                                                    <div class="invalid-alert text-danger">
                                                        {{ $errors->first('note.' . $i) }}
                                                    </div>
                                                @endif
                                            </td>
                                            {{-- <td>
                                                <button style="border-radius:50%" type="button"
                                                    class="btn btn-danger btn-sm minus_record">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </td> --}}
                                        </tr>
                                    @endfor
                                @else
                                    @foreach ($services as $key => $value)
                                        <tr>
                                            <td class="text-center align-middle">1</td>
                                            <td class="text-center align-middle">
                                                <select class="form-control select2 service_change" name="services[]">
                                                    <option selected="selected" value=" ">Dịch vụ
                                                    </option>
                                                    @foreach ($services as $item)
                                                        <option @if ($value->service_id == $item->id) selected @endif
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
                                                <input name="time_view[]"
                                                    class="form-control form-control-border number-hidden-input text-center input-time"
                                                    type="number" min="1" max="10000"
                                                    value="{{ $value->time }}"
                                                    {{ $value->time == null ? 'disabled' : '' }}>
                                                <input type="hidden" name="time[]" value="{{ $value->time }}">
                                            </td>
                                            <td class="text-center">
                                                <input name="start[]" type="text"
                                                    class="datepicker_start form-control text-center"
                                                    value="{{ date('d/m/Y', strtotime($value->started_at)) }}">
                                            </td>
                                            <td class="text-center">
                                                <input name="end[]" type="text"
                                                    class="datepicker_end form-control text-center"
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
                                                <select class="form-control select2" name="supplier[]">
                                                    <option selected="selected" value=" "></option>
                                                    @foreach ($suppliers as $item)
                                                        <option @if ($item->id == $value->supplier) selected @endif
                                                            value="{{ $item->id }}">
                                                            {{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="note[]" class="form-control"
                                                    value="{{ $value->note }}">
                                            </td>
                                            
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end mt-2">
                            <button class="btn btn-primary" type="submit">{{ trans('language.save') }}</button>
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
                    <select class="form-control service_change" name="services[]">
                        <option selected="selected" value=" ">Dịch vụ</option>
                        @foreach ($list_services as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td class="d-flex justify-content-center align-items-center">
                    <input name="time_view[]"
                        class="form-control form-control-border number-hidden-input text-center input-time"
                        type="number" min="1" max="10000" value="" disabled>
                    <input type="hidden" name="time[]">
                </td>
                <td class="text-center">
                    <input name="start[]" type="text" class="datepicker_start_sv form-control text-center">
                </td>
                <td class="text-center">
                    <input name="end[]" type="text" class="datepicker_end_sv form-control text-center">
                </td>
                <td class="text-center align-middle">
                    <input type="text" name="view_total[]" class="form-control view-total" value="">
                    <input type="hidden" name="subtotal[]" value="">
                    <input type="hidden" class="price_ser" name="price_ser[]" value="">
                </td>
                <td>
                    <select class="form-control" name="supplier[]">
                        <option selected="selected" value=" "></option>
                        @foreach ($suppliers as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="text" name="note[]" class="form-control">
                </td>
               
            </tr>
        </tbody>
    </table>
</div>
