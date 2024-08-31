@extends('layouts.front', ['class' => ''])

@section('content')
   <section class="section">
    <div class="container">
        <br /><br />
        <div class="alert alert-danger" role="alert">
            {{ __('You have provided  address that we can not find') }}. 
        </div>
        <br />
        <p>
        <a class="btn btn-danger" href="{{ url()->previous() }}">{{ __('Go back')}}</a>
        </p>
    </div>
   </section>
@endsection