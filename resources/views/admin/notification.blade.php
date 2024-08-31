@extends('layouts.app', ['title' => __('Notification Alert')])

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
                                <h3 class="mb-0">{{ __('Notification Alert') }}</h3>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <h6 class="heading-small text-muted mb-4">{{ __('Send Notification To All Mobile Users') }}</h6>
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="pl-lg-4">
                            <form method="post" action="{{ route('notifications.send') }}" autocomplete="off" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group{{ $errors->has('title') ? ' has-danger' : '' }} col-md-6">
                                    <label class="form-control-label" for="title">{{ __('Title') }}</label>
                                    <input type="text" name="title" id="title" class="form-control form-control-alternative{{ $errors->has('title') ? ' is-invalid' : '' }}" placeholder="{{ __('Title here ...') }}" value="{{isset($extraGroup) ? $extraGroup->title:old('title')}}" required autofocus>
                                    @if ($errors->has('title'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('body') ? ' has-danger' : '' }} col-md-6">
                                    <label class="form-control-label" for="body">{{ __('Body') }}</label>
                                    <textarea name="body" id="body" class="form-control" rows="8" placeholder="body here .........">{{old('body')}}</textarea>
                                    @if ($errors->has('body'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('body') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="text-center col-md-6">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Send') }}</button>
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
