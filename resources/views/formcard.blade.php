@extends('layout')

@section('content')

    <div class="container">
        <!-- Page Content goes here -->
        <div class="row">
            <div class="col s12">
                <div class="card-panel">
                    @yield('cardcontents')
                </div>
            </div>
        </div>
    </div>

@endsection