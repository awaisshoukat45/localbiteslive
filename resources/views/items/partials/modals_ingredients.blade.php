<div class="modal fade" id="modal-new-ingredient" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-new-extras">{{ __('Add New Food Item') }}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5">
                        <form role="form" method="post" action="{{ route('ingredients.store', $item) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group{{ $errors->has('ingredient_name') ? ' has-danger' : '' }}">
                                <input class="form-control" name="ingredient_name" id="ingredient_name" placeholder="{{ __('Name') }} ..." type="text" required>
                                @if ($errors->has('ingredient_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('ingredient_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('food_ingredient_id') ? ' has-danger' : '' }}">
                                <select class="form-control" name="food_ingredient_id" required>
                                    <option disabled selected>Food Item Groups</option>
                                    @foreach($foodIngredientGroups as $ingredientGroup)
                                        <option value="{{$ingredientGroup->id}}">{{$ingredientGroup->name}} </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('food_ingredient_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('food_ingredient_id') }}</strong>
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
<div class="modal fade" id="modal-edit-ingredients" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-new-extras">{{ __('Edit Food Item') }}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5">
                        <form role="form" method="post" action="{{ route('ingredients.edit', $item) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group{{ $errors->has('ingredient_name_edit') ? ' has-danger' : '' }}">
                                <input class="form-control" name="ingredient_name_edit" id="ingredient_name_edit" placeholder="{{ __('Name') }} ..." type="text" required autofocus>
                                @if ($errors->has('ingredient_name_edit'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('ingredient_name_edit') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('ingredient_group_id_edit') ? ' has-danger' : '' }}">
                                <select class="form-control" id="ingredient_group_id_edit" name="ingredient_group_id_edit" required>
                                    <option disabled selected>Food Item Groups</option>
                                    @foreach($foodIngredientGroups as $ingredientGroup)
                                        <option value="{{$ingredientGroup->id}}">{{$ingredientGroup->name}} </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('ingredient_group_id_edit'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('ingredient_group_id_edit') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <input name="ingredient_id" id="ingredient_id" type="hidden" required>
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

