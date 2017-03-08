@extends('layout')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col s12">
                <div class="card white">
                    <div class="card-content black-text">
                        @yield('cardcontents')
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
