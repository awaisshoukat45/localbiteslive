@extends('layouts.app', ['title' => __('Pages')])

@section('content')
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    </div>

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Plans') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('plans.create') }}" class="btn btn-sm btn-primary">{{ __('Add plan') }}</a>
                            </div>
                        </div>
                    </div>

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
                    @if(count($plans))
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('Name') }}</th>
                                    <th scope="col">{{ __('Price') }}</th>
                                    <th scope="col">{{ __('Period') }}</th>
                                    <th scope="col">{{ __('Orders limit') }}</th>
                                    <th scope="col">{{ __('Items limit') }}</th>
                                    <th scope="col">{{ __('Paddle ID') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($plans as $plan)
                                <tr>
                                    <td>{{ $plan->name }} </td>
                                    <td>{{ $plan->price }}</td>
                                    <td>{{ $plan->period == 1 ? "Monthly" : "Anually" }}</td>
                                    <td>{{ $plan->limit_orders == 0 ? "Unlimited" : $plan->limit_orders }}</td>
                                    <td>{{ $plan->limit_items == 0 ? "Unlimited" : $plan->limit_items }}</td>
                                    <td>{{ $plan->paddle_id }}</td>
                                    <td class="text-right">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <form action="{{ route('plans.destroy', $plan) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this plan?") }}') ? this.parentElement.submit() : ''">
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
                    @endif
                    <div class="card-footer py-4">
                        @if(count($plans))
                            <nav class="d-flex justify-content-end" aria-label="...">
                                {{ $plans->links() }}
                            </nav>
                        @else
                            <h4>{{ __('You don`t have any plans') }} ...</h4>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection
