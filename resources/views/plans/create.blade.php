@extends('layouts.app', ['title' => __('Plan')])

@section('content')
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
</div>
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Plans Management') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('plans.index') }}" class="btn btn-sm btn-primary">{{ __('Back to plans') }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="heading-small text-muted mb-4">{{ __('Plan information') }}</h6>
                    @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    <div class="pl-lg-4">
                        <form method="post" action="{{ route('plans.store') }}" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="name">{{ __('Name') }}</label>
                                <input type="text" name="name" id="name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name here ...') }}" value="" required autofocus>
                                @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('price') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="price">{{ __('Price') }}</label>
                                <input type="number" step="any"  name="price" id="price" class="form-control form-control-alternative{{ $errors->has('price') ? ' is-invalid' : '' }}" placeholder="{{ __('Price here ...') }}" value="" required autofocus>
                                @if ($errors->has('price'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('price') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('items_limit') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="items_limit">{{ __('Items limit') }}</label>
                                        <input type="number" step="any"  name="items_limit" id="items_limit" class="form-control form-control-alternative{{ $errors->has('items_limit') ? ' is-invalid' : '' }}" placeholder="{{ __('Number of items here ...') }}" value="" required autofocus>
                                        <small class="text-muted"><strong>0</strong> is unlimited numbers of items</small>
                                        @if ($errors->has('items_limit'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('items_limit') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('orders_limit') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="orders_limit">{{ __('Orders limit') }}</label>
                                        <input type="number" step="any"  name="orders_limit" id="orders_limit" class="form-control form-control-alternative{{ $errors->has('orders_limit') ? ' is-invalid' : '' }}" placeholder="{{ __('Number of orders here ...') }}" value="" required autofocus>
                                        <small class="text-muted"><strong>0</strong> is unlimited numbers of orders</small>
                                        @if ($errors->has('orders_limit'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('orders_limit') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="custom-control custom-radio mb-3">
                                <input name="period" class="custom-control-input" id="monthly" checked="" value="monthly" type="radio">
                                <label class="custom-control-label" for="monthly">Monthly</label>
                            </div>
                            <div class="custom-control custom-radio mb-3">
                                <input name="period" class="custom-control-input" id="anually" value="anually" type="radio">
                                <label class="custom-control-label" for="anually">Anually</label>
                            </div>
                            <br/>
                            <div class="form-group{{ $errors->has('paddle_id') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="paddle_id">{{ __('Paddle ID') }}</label>
                                <input type="number" step="any"  name="paddle_id" id="paddle_id" class="form-control form-control-alternative{{ $errors->has('paddle_id') ? ' is-invalid' : '' }}" placeholder="{{ __('Paddle ID here ...') }}" value="" required autofocus>
                                @if ($errors->has('paddle_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('paddle_id') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.footers.auth')
</div>
@endsection
