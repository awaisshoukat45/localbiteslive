@extends('layouts.app', ['title' => __('Extra Group')])

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
                                <h3 class="mb-0">{{ __('Food Item Group') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('ingredient-groups.index') }}" class="btn btn-sm btn-primary">{{ __('Back to Groups') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h6 class="heading-small text-muted mb-4">{{ __('Group information') }}</h6>
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="pl-lg-4">
                            @if(isset($foodIngredient))
                            <form method="post" action="{{ route('ingredient-groups.update',$foodIngredient->id) }}" autocomplete="off" enctype="multipart/form-data">
                                    @method('PUT')
                                @else
                                <form method="post" action="{{ route('ingredient-groups.store') }}" autocomplete="off" enctype="multipart/form-data">
                                    @endif
                                @csrf
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="title">{{ __('Name') }}</label>
                                    <input type="text" name="name" id="name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name here ...') }}" value="{{isset($foodIngredient) ? $foodIngredient->name:old('name')}}" required autofocus>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
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
