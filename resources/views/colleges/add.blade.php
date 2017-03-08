@extends('layout')

@section('content')

    <div class="container">
        <!-- Page Content goes here -->
        <div class="row">
            <div class="col s12 m12 l6">
                <div class="card-panel">
                    <h4 class="header2">Colleges</h4>
                    <div class="row">
                        <form class="col s12" action="{{ route('collegesPostAdd') }}" method="post">
                            {{ csrf_field() }}
                            <div class="input-field col s12">
                                    <select name="college" title="Colleges">
                                        <option value="" disabled selected>Choose your option</option>
                                        @foreach($colleges as $college)
                                            <option value="{{ $college->key()->pathEndIdentifier() }}">{{ $college['name'] }}</option>
                                        @endforeach
                                    </select>
                                    <label>Select a college</label>
                                </div>
                            <div class="input-field col s12">
                                    <button class="btn cyan waves-effect waves-light right" type="submit" name="action">Submit
                                        <i class="mdi-content-send right"></i>
                                    </button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
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