@extends('layout')

@section('content')

    <div class="container">
        <!-- Page Content goes here -->
        <h2 class="header">Edit Profile</h2>
        <div class="row">
            <form class="col s12" action="{{ route('postProfile') }}" method="post">
                {{ csrf_field() }}
                <div class="row">
                    <div class="input-field col s12">
                        <input value="{{ $user['name'] }}" id="name" type="text" class="validate">
                        <label for="name">Name</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input value="{{ $user['email'] }}" id="email" type="email" class="validate">
                        <label for="email">Email</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <button class="btn cyan waves-effect waves-light right" type="submit" name="action" >Submit
                            <i class="mdi-content-send right"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection