@extends('layouts.front', ['title' => __('Restaurants')])

@section('content')
<div class="section section-hero section-shaped">
      <!--<div class="page-header">
        <div class="container shape-container d-flex align-items-center py-lg">
          <div class="col px-0">
            <div class="row align-items-center justify-content-center">
              <div class="col-lg-6 text-center">
                <h1 class="display-1">People stories</h1>
                <h2 class="display-4 font-weight-normal">The time is right now!</h2>
                <div class="btn-wrapper mt-4">
                  <a href="https://www.creative-tim.com/product/argon-design-system" class="btn btn-warning btn-icon mt-3 mb-sm-0">
                    <span class="btn-inner--icon"><i class="ni ni-button-play"></i></span>
                    <span class="btn-inner--text">Play more</span>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>-->
      <!--<div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <polygon class="fill-white" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </div>-->
    <div class="section features-1">
      <div class="container-fluid">
        <!--<div class="row">
          <div class="col-md-8 mx-auto text-center">
            <span class="badge badge-primary badge-pill mb-3">Insight</span>
            <h3 class="display-3">Full-Funnel Social Analytics</h3>
            <p class="lead">The time is now for it to be okay to be great. For being a bright color. For standing out.</p>
          </div>
        </div>-->
        <div class="row">
            <div class="col-md-3">
                <form>
                    <div class="form-group">
                        <div class="input-group mb-4 border border-danger">
                        <input class="form-control" name="location" id="txtlocation" value="{{ request()->get('location') }}" type="text">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="ni ni-pin-3"></i></span>
                        </div>
                    </div>
                </form>
            </div>
          </div>
          <div class="col-md-9">
            <h6 class="info-title text-uppercase text-warning">Recommended for you</h6>
            <div class="row">
                @forelse ($restorants as $restorant)
                    <?php $link=route('vendor',['alias'=>$restorant->alias]); ?>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                        <div class="strip">
                            <figure>
                            <a href="{{ $link }}"><img src="{{ $restorant->logom }}" data-src="{{ config('global.restorant_details_image') }}" class="img-fluid lazy" alt=""></a>
                            </figure>
                            <span class="res_title"><b><a href="{{ $link }}">{{ $restorant->name}}</a></b></span><br />
                            <span class="res_description">{{ $restorant->description}}</span><br />
                            <span class="res_mimimum">{{ __('Minimum order') }}: @money($restorant->minimum, env('CASHIER_CURRENCY','usd'),true)</span>

                        </div>
                    </div>
                    @empty
                    <div class="col-md-12">
                    <p class="text-muted mb-0">{{ __('Hmmm... Nothing found!')}}</p>
                    </div>

                    @endforelse
            </div>
          </div>
          <!--<div class="col-md-3">
            <div class="info">
              <div class="icon icon-lg icon-shape icon-shape-warning shadow rounded-circle">
                <i class="ni ni-world"></i>
              </div>
              <h6 class="info-title text-uppercase text-warning">Measure Conversions</h6>
              <p class="description opacity-8">What else could rust the heart more over time? Blackgold. The time is now for it to be okay to be great. or being a bright color. For standing out.</p>
              <a href="javascript:;" class="text-primary">Check our documentation
                <i class="ni ni-bold-right text-primary"></i>
              </a>
            </div>-->
          </div>
        </div>
      </div>
    </div>
@endsection
