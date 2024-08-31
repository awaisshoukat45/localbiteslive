@extends('layouts.app', ['title' => __('Extra Groups')])

@section('content')
{{--    @include('restorants.partials.modals')--}}
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    </div>

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Extra Groups') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('extra-groups.create') }}" class="btn btn-sm btn-primary">{{ __('Add Extra Group') }}</a>
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
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">{{ __('Name') }}</th>
                                <th scope="col">{{ __('Creation Date') }}</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($extraGroups as $extraGroup)
                                <tr>
                                    <td ><a href="{{ route('extra-groups.edit', $extraGroup) }}">{{ $extraGroup->name }}</a></td>
                                    <td>{{ $extraGroup->created_at->format(env('DATETIME_DISPLAY_FORMAT','d M Y H:i')) }}</td>
                                    <td class="text-right">
                                        @can('edit-extras-groups',$extraGroup)
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">

                                                <form action="{{ route('extra-groups.destroy', $extraGroup) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <a class="dropdown-item" href="{{ route('extra-groups.edit', $extraGroup) }}">{{ __('Edit') }}</a>
                                                    <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this user?") }}') ? this.parentElement.submit() : ''">
                                                        {{ __('Delete') }}
                                                    </button>
                                                </form>

                                            </div>
                                        </div>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer py-4">
                        <nav class="d-flex justify-content-end" aria-label="...">
                            {{ $extraGroups->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection
