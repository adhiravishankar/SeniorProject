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
                        <a href="{{ route('editProfile') }}">Edit Profile</a>
                    </div>
                </div>
            </div>
            <div class="col s12 m6">
                <div class="card white">
                    <div class="card-content black-text">
                        <span class="card-title">Colleges</span>
                        <div class="collection">
                            @foreach($colleges as $college)
                                <a href="{{ route('collegesDetails', ['id' => $college->key()->pathEndIdentifier() ]) }}" class="collection-item">{{ $college->offsetGet('name') }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection