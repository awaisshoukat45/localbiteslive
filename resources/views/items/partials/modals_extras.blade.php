<div class="modal fade" id="modal-new-extras" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-new-extras">{{ __('Add new extras') }}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5">
                        <form role="form" method="post" action="{{ route('extras.store', $item) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group{{ $errors->has('extras_name') ? ' has-danger' : '' }}">
                                <input class="form-control" name="extras_name" id="extras_name" placeholder="{{ __('Name') }} ..." type="text" required>
                                @if ($errors->has('extras_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('extras_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('extra_group_id') ? ' has-danger' : '' }}">
                                <select class="form-control" name="extra_group_id" required>
                                    <option disabled selected>Extras Groups</option>
                                    @foreach($extraGroups as $extraGroup)
                                        <option value="{{$extraGroup->id}}">{{$extraGroup->name}} </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('extra_group_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('extra_group_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('extras_price') ? ' has-danger' : '' }}">
                                <input class="form-control" name="extras_price" id="extras_price" placeholder="{{ __('Price') }} ..." type="number" step="any" required>
                                @if ($errors->has('extras_price'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('extras_price') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <input name="category_id" id="category_id" type="hidden" required>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary my-4">{{ __('Save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-edit-extras" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-new-extras">{{ __('Edit extras') }}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5">
                        <form role="form" method="post" action="{{ route('extras.edit', $item) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group{{ $errors->has('extras_name_edit') ? ' has-danger' : '' }}">
                                <input class="form-control" name="extras_name_edit" id="extras_name_edit" placeholder="{{ __('Name') }} ..." type="text" required autofocus>
                                @if ($errors->has('extras_name_edit'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('extras_name_edit') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('extra_group_id_edit') ? ' has-danger' : '' }}">
                                <select class="form-control" id="extra_group_id_edit" name="extra_group_id_edit" required>
                                    <option disabled selected>Extras Groups</option>
                                    @foreach($extraGroups as $extraGroup)
                                        <option value="{{$extraGroup->id}}">{{$extraGroup->name}} </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('extra_group_id_edit'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('extra_group_id_edit') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('extras_price_edit') ? ' has-danger' : '' }}">
                                <input class="form-control" name="extras_price_edit" id="extras_price_edit" placeholder="{{ __('Price') }} ..." type="number" step="any" required autofocus>
                                @if ($errors->has('extras_price_edit'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('extras_price_edit') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <input name="extras_id" id="extras_id" type="hidden" required>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary my-4">{{ __('Save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

