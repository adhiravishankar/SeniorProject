@extends('formcard')

@section('cardcontents')

    <h4 class="header2">Explore</h4>
    <div class="row">
        <div class="input-field col s12 m6 l3">
            <select title="college">
                <option value="" disabled selected>Choose your option</option>
                @foreach($colleges as $college)
                    <option value="{{ $college->key()->pathEndIdentifier() }}">{{ $college['name'] }}</option>
                @endforeach
            </select>
            <label>Colleges</label>
        </div>
        <div class="input-field col s12 m6 l3">
            <select title="major">
                <option value="" disabled selected>Choose your option</option>
                @foreach($majors as $major)
                    <option value="{{ $major->key()->pathEndIdentifier() }}">{{ $major['name'] }}</option>
                @endforeach
            </select>
            <label>Majors</label>
        </div>
        <div class="input-field col s12 m6 l3">
            <select title="degree">
                <option value="" disabled selected>Choose your option</option>
                @foreach($degrees as $degree)
                    <option value="{{ $loop->iteration }}">{{ $degree }}</option>
                @endforeach
            </select>
            <label>Degrees</label>
        </div>
        <div class="input-field col s12 m6 l3">
            <select title="geo">
                <option value="" disabled selected>Choose your option</option>
                @foreach($geos as $geo)
                    <option value="{{ $loop->iteration }}">{{ $geo }}</option>
                @endforeach
            </select>
            <label>Geographies</label>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m6 l3">
            <div id="gpa"></div>
        </div>
    </div>
    @if(!isset($statistics))
        <div class="row">
            <div class="valign-wrapper col s12" style="min-height: 300px;">
                <h5 class="valign center-align col s12">There are no statistics available.</h5>
            </div>
        </div>
    @else
        @foreach($statistics as $statistic)

        @endforeach
    @endif

@endsection

@section('scripts')

    <script type="text/javascript" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/9.2.0/nouislider.min.js" ></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('select').material_select();
        });
    </script>
    <script type="text/javascript">
        var slider = document.getElementById('gpa');
        noUiSlider.create(slider, {
            start: [0, 10],
            connect: true,
            step: 0.1,
            range: {
                'min': 0,
                'max': 10
            },
            format: wNumb({
                decimals: 0
            })
        });
    </script>

@endsection

@section('styles')

    <style type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/9.2.0/nouislider.min.css" ></style>

@endsection