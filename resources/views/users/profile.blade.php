@extends('layout')

@section('content')

    <div class="container">
        <!-- Page Content goes here -->

        <div class="row">
            <div class="col s12 m6">
                <div class="card white">
                    <div class="card-content black-text">
                        <span class="card-title">{{ $user['name'] }}</span>
                        <p></p>
                    </div>
                    <div class="card-action">
                        <a href="#">Edit Profile</a>
                        <a href="#"></a>
                    </div>
                </div>
            </div>
            <div class="col s12 m6">
                <div class="card white">
                    <div class="card-content black-text">
                        <span class="card-title">Colleges</span>
                        <div class="collection">
                            <a href="#!" class="collection-item">Alvin</a>
                            <a href="#!" class="collection-item">Alvin</a>
                            <a href="#!" class="collection-item">Alvin</a>
                            <a href="#!" class="collection-item">Alvin</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection