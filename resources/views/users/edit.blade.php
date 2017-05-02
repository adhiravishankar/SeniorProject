@extends('layout')

@section('content')

    <div class="container">
        <!-- Page Content goes here -->
        <h2 class="header">Edit Profile</h2>
        <div class="row">
            <form class="col s12" action="{{ route('postProfile') }}" method="post">
                {{ csrf_field() }}
                <div class="row">
                    <div class="input-field col s12 l6">
                        <input value="{{ $user['name'] }}" name="name" id="name" type="text" class="validate">
                        <label for="name">Name</label>
                    </div>
                    <div class="input-field col s12 l6">
                        <input value="{{ $user['email'] }}" name="email" id="email" type="email" class="validate">
                        <label for="email">Email</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m6 l2">
                        <input value="{{ $user['gpa'] }}" id="gpa" name="gpa" type="number" step="0.01" max="10" min="0" class="validate">
                        <label for="gpa">GPA</label>
                    </div>
                    <div class="input-field col s12 m6 l2">
                        <input value="{{ $user['grev'] }}" id="grev" name="grev" type="number" step="1" max="170" min="130" class="validate">
                        <label for="grev">GRE Verbal</label>
                    </div>
                    <div class="input-field col s12 m6 l2">
                        <input value="{{ $user['grem'] }}" id="grem" name="grem" type="number" step="1" max="170" min="130" class="validate">
                        <label for="grem">GRE Quantitative</label>
                    </div>
                    <div class="input-field col s12 m6 l2">
                        <input value="{{ $user['grew'] }}" id="grew" type="number" step="0.5" max="6" min="0" class="validate">
                        <label for="grew">GRE Writing</label>
                    </div>
                    <div class="input-field col s12 m6 l2">
                        <input value="{{ $user['gmat'] }}" id="gmat" type="number" step="1" max="800" min="200" class="validate">
                        <label for="gmat">GMAT</label>
                    </div>
                    <div class="input-field col s12 m6 l2">
                        <input value="{{ $user['lsat'] }}" id="lsat" type="number" step="1" max="180" min="120" class="validate">
                        <label for="lsat">LSAT</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 l4">
                        <select name="major" title="Majors">
                            <option value="" disabled selected>Choose your option</option>
                            @foreach($majors as $major)
                                <option value="{{ $major->key()->pathEndIdentifier() }}">{{ $major['name'] }}</option>
                            @endforeach
                        </select>
                        <label>Select a major</label>
                    </div>
                    <div class="input-field col s12 l4">
                        <select name="major" title="Majors">
                            <option value="" disabled selected>Choose your option</option>
                            @foreach($majors as $major)
                                <option value="{{ $major->key()->pathEndIdentifier() }}">{{ $major['name'] }}</option>
                            @endforeach
                        </select>
                        <label>Select a major</label>
                    </div>
                    <div class="input-field col s12 l4">
                        <select name="major" title="Majors">
                            <option value="" disabled selected>Choose your option</option>
                            @foreach($majors as $major)
                                <option value="{{ $major->key()->pathEndIdentifier() }}">{{ $major['name'] }}</option>
                            @endforeach
                        </select>
                        <label>Select a major</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <button class="btn cyan waves-effect waves-light right" type="submit" name="action" >Submit
                            <i class="zmdi zmdi-mail-send"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')

    <script type="text/javascript">
        $(document).ready(function() {
            $('select').material_select();
        });
    </script>

@endsection