@extends('layouts.app', ['title' => __('Orders')])

@section('content')
    @include('items.partials.modals_extras', ['item' => $item ,'extraGroups'=>$extraGroups])
    @include('items.partials.modals_ingredients', ['item' => $item ,'foodIngredientGroups'=>$foodIngredientGroups])
    <script>
        function setRestaurantId(id){
            $('#res_id').val(id);
        }
    </script>
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    </div>
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-7">
                <br/>
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Item Management') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                @if(auth()->user()->hasRole('owner'))
                                    <a href="{{ route('items.index') }}" class="btn btn-sm btn-primary">{{ __('Back to items') }}</a>
                                @elseif(auth()->user()->hasRole('admin'))
                                    <a href="{{ route('items.admin', $restorant) }}" class="btn btn-sm btn-primary">{{ __('Back to items') }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="col-12">
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <h6 class="heading-small text-muted mb-4">{{ __('Item information') }}</h6>
                        <div class="pl-lg-4">
                            <form method="post" action="{{ route('items.update', $item) }}" autocomplete="off" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group{{ $errors->has('item_name') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="item_name">{{ __('Item Name') }}</label>
                                            <input type="text" name="item_name" id="item_name" class="form-control form-control-alternative{{ $errors->has('item_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('item_name', $item->name) }}" required autofocus>
                                            @if ($errors->has('item_name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('item_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group{{ $errors->has('item_description') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="item_description">{{ __('Item Description') }}</label>
                                            <textarea id="item_description" name="item_description" class="form-control form-control-alternative{{ $errors->has('item_description') ? ' is-invalid' : '' }}" placeholder="{{ __('Item Description here ... ') }}" value="{{ old('item_description', $item->description) }}" required autofocus rows="3">{{ old('item_description', $item->description) }}</textarea>
                                            @if ($errors->has('item_description'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('item_description') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group{{ $errors->has('item_price') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="item_price">{{ __('Item Price') }}</label>
                                            <input type="number" step="any" name="item_price" id="item_price" class="form-control form-control-alternative{{ $errors->has('item_price') ? ' is-invalid' : '' }}" placeholder="{{ __('Price') }}" value="{{ old('item_price', $item->price) }}" required autofocus>
                                            @if ($errors->has('item_price'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('item_price') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <?php $image=['name'=>'item_image','label'=>__('Item Image'),'value'=> $item->logom,'style'=>'width: 290px; height:200']; ?>
                                        @include('partials.images',$image)
                                        <div class="form-group">
                                            <label class="form-control-label" for="item_price">{{ __('Item available') }}</label>
                                            <label class="custom-toggle" style="float: right">
                                                <input type="checkbox" id="itemAvailable" class="itemAvailable" itemid="{{ $item->id }}" <?php if($item->available == 1){echo "checked";}?>>
                                                <span class="custom-toggle-slider rounded-circle"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    </div>
                                </div>
                                <div class="text-center">
                                   <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                </div>
                            </form>
                            <div class="text-center">
                                <form action="{{ route('items.destroy', $item) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="button" class="btn btn-danger mt-4" onclick="confirm('{{ __("Are you sure you want to delete this item?") }}') ? this.parentElement.submit() : ''">{{ __('Delete') }}</button>
                                </form>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5 mb-5 mb-xl-0">
                    <br/>
                    <div class="card card-profile shadow">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h5 class="h3 mb-0">{{ __('Extras') }}</h5>
                                </div>
                                <div class="col-4 text-right">
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-new-extras" onClick=(setRestaurantId({{ $restorant_id }}))>{{ __('Add') }}</button>
                                    <!--@if(auth()->user()->hasRole('admin'))
                                        <a href="{{ route('items.admin', $restorant) }}" class="btn btn-sm btn-primary">View Items</a>
                                    @endif-->
                                </div>
                            </div>
                        </div>
                            <div class="table-responsive">
                                <table class="table align-items-center">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" class="sort" data-sort="name">Name</th>
                                            <th scope="col" class="sort" data-sort="name">Group</th>
                                            <th scope="col" class="sort" data-sort="name">Price</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="list">
                                        @foreach($item->extras as $extra)
                                            <tr>
                                                <th scope="row">{{ $extra->name }}</th>
                                                <th scope="row">{{(isset($extra->extrasGroup))?$extra->extrasGroup->name : "-" }}</th>
                                                <td class="budget">@money( $extra->price, env('CASHIER_CURRENCY','usd'),true)</td>
                                                <td class="text-right">
                                                    <div class="dropdown">
                                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                            <button type="button" class="dropdown-item" data-toggle="modal" data-target="#modal-edit-extras" onClick=(setExtrasId({{ $extra->id }}))>Edit</button>
                                                            <form action="{{ route('extras.destroy',[$item, $extra]) }}" method="post">
                                                                @csrf
                                                                @method('delete')

                                                                <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this extras?") }}') ? this.parentElement.submit() : ''">
                                                                    {{ __('Delete') }}
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                    </div>
                    <div class="card card-profile shadow mt-5">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h5 class="h3 mb-0">{{ __('Food Item Groups') }}</h5>
                                </div>
                                <div class="col-4 text-right">
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-new-ingredient" onClick=(setRestaurantId({{ $restorant_id }}))>{{ __('Add') }}</button>
                                    <!--@if(auth()->user()->hasRole('admin'))
                                        <a href="{{ route('items.admin', $restorant) }}" class="btn btn-sm btn-primary">View Items</a>
                                    @endif-->
                                </div>
                            </div>
                        </div>
                            <div class="table-responsive">
                                <table class="table align-items-center">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" class="sort" data-sort="name">Name</th>
                                            <th scope="col" class="sort" data-sort="name">Group</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="list">
                                        @foreach($item->ingredients as $ingredient)
                                            <tr>
                                                <th scope="row">{{ $ingredient->name }}</th>
                                                <th scope="row">{{(isset($ingredient->ingredientGroup))?$ingredient->ingredientGroup->name : "-" }}</th>
                                                <td class="text-right">
                                                    <div class="dropdown">
                                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                            <button type="button" class="dropdown-item" data-toggle="modal" data-target="#modal-edit-ingredients" onClick=(setIngredientId({{ $ingredient->id }}))>Edit</button>
                                                            <form action="{{ route('extras.destroy',[$item, $ingredient]) }}" method="post">
                                                                @csrf
                                                                @method('delete')

                                                                <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this extras?") }}') ? this.parentElement.submit() : ''">
                                                                    {{ __('Delete') }}
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                    </div>
            </div>
        </div>
        @include('layouts.footers.auth')
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        function setExtrasId(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type:'GET',
                url: '/extras/'+id,
                success:function(response){
                    if(response.status){
                        $('#extras_id').val(id);

                        $('#extras_name_edit').val(response.data.name);
                        console.log(response.data);
                        $('#extra_group_id_edit').val(response.data.extra_group_id);
                        $('#extras_price_edit').val(response.data.price);
                    }
                }, error: function (response) {
                    //return callback(false, response.responseJSON.errMsg);
                }
            })
        }
        function setIngredientId(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type:'GET',
                url: '/ingredients/'+id,
                success:function(response){
                    if(response.status){
                        console.log(response.data);
                        $('#ingredient_id').val(id);

                        $('#ingredient_name_edit').val(response.data.name);
                        $('#ingredient_group_id_edit').val(response.data.food_ingredient_id);
                    }
                }, error: function (response) {
                    //return callback(false, response.responseJSON.errMsg);
                }
            })
        }
    </script>
@endsection
