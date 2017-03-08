@extends('layout')

@section('content')

    <div class="container">
        <!-- Page Content goes here -->
        <div class="row">
            <div class="col s12">
                <div class="card white">
                    <div class="card-content black-text">
                        <span class="card-title">Majors<a class="waves-effect waves-light btn">Add</a></span>
                        <table>
                            <thead>
                                <tr>
                                    <th data-field="id">Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($majors as $major)
                                    <tr>
                                        <td>
                                            <a href="{{ route('collegesDetails', ['id' => base_convert($major->key()->pathEndIdentifier(), 10, 36) ]) }}">
                                                {{ $major['name'] }}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection