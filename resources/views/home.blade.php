@extends('formcard')

@section('cardcontents')

    <h4 class="header2">Explore</h4>
    <form method="get">
        <div class="row">
        <div class="input-field col s12 m6 l3">
            <select name="college" title="college">
                @if($selected_college)
                    <option value="" disabled>Choose your option</option>
                @else
                    <option value="" disabled selected>Choose your option</option>
                @endif
                @foreach($colleges as $college)
                    @if($college->key()->pathEndIdentifier() == $selected_college)
                        <option value="{{ $college->key()->pathEndIdentifier() }}" selected>{{ $college['name'] }}</option>
                    @else
                        <option value="{{ $college->key()->pathEndIdentifier() }}">{{ $college['name'] }}</option>
                    @endif
                @endforeach
            </select>
            <label>Colleges</label>
        </div>
        <div class="input-field col s12 m6 l2">
            <select name="major" title="major">
                @if($selected_major)
                    <option value="" disabled>Choose your option</option>
                @else
                    <option value="" disabled selected>Choose your option</option>
                @endif
                @foreach($majors as $major)
                    @if($major->key()->pathEndIdentifier() == $selected_major)
                        <option value="{{ $major->key()->pathEndIdentifier() }}" selected>{{ $major['name'] }}</option>
                    @else
                        <option value="{{ $major->key()->pathEndIdentifier() }}">{{ $major['name'] }}</option>
                    @endif
                @endforeach
            </select>
            <label>Majors</label>
        </div>
        <div class="input-field col s12 m6 l1">
            <select name="degree" title="degree">
                @if($selected_degree)
                    <option value="" disabled>Choose your option</option>
                @else
                    <option value="" disabled selected>Choose your option</option>
                @endif
                @foreach($degrees as $degree)
                    @if($loop->iteration == $selected_degree)
                        <option value="{{ $loop->iteration }}" selected>{{ $degree }}</option>
                    @else
                        <option value="{{ $loop->iteration }}">{{ $degree }}</option>
                    @endif
                @endforeach
            </select>
            <label>Degrees</label>
        </div>
        <div class="input-field col s12 m6 l2">
            <select name="geo" title="geo">
                @if($selected_geo)
                    <option value="" disabled>Choose your option</option>
                @else
                    <option value="" disabled selected>Choose your option</option>
                @endif
                @foreach($geos as $geo)
                    @if($loop->iteration == $selected_geo)
                        <option value="{{ $loop->iteration }}" selected>{{ $geo }}</option>
                    @else
                        <option value="{{ $loop->iteration }}">{{ $geo }}</option>
                    @endif
                @endforeach
            </select>
            <label>Geographies</label>
        </div>
            <div class="input-field col s12 m6 l2">
                <select name="graph" title="graph">
                    @if($selected_graph)
                        <option value="" disabled>Choose your option</option>
                    @else
                        <option value="" disabled selected>Choose your option</option>
                    @endif
                    @if($selected_graph == 1)
                        <option value="1" selected>GPA</option>
                    @else
                        <option value="1">GPA</option>
                    @endif
                    @if($selected_graph == 2)
                        <option value="2" selected>GRE Verbal</option>
                    @else
                        <option value="2">GRE Verbal</option>
                    @endif
                </select>
                <label>Graph</label>
            </div>
        <div class="input-field col s12 m6 l2">
            <button class="btn waves-effect waves-light" type="submit" name="action">Submit
                <i class="material-icons right">send</i>
            </button>
        </div>
    </div>
    </form>
    <div class="row">
        <div class="col s12 l3">
            GPA
            <div id="gpa" style="font-size:20px;">{{ $gpa }}%</div>
        </div>
        <div class="col s12 l3">
            GRE Math
            <div id="gre_math" style="font-size:20px;">{{ $gre_math }}%</div>
        </div>
        <div class="col s12 l3">
            GRE Verbal
            <div id="gre_verbal" style="font-size:20px;">{{ $gre_verbal }}%</div>
        </div>
        <div class="col s12 l3">
            Average
            <div id="gre_verbal" style="font-size:20px;">{{ $average }}%</div>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <div id="container" class="col s12"><canvas id="chart"></canvas></div>
        </div>
    </div>

    @if(!isset($statistics))
        <div class="row">
            <div class="valign-wrapper col s12" style="min-height: 300px;">
                <h5 class="valign center-align col s12">There are no statistics available.</h5>
            </div>
        </div>
    @endif

@endsection

@section('scripts')

    <script type="text/javascript">
        $(document).ready(function() {
            $('select').material_select();
        });
    </script>

    @if($decisions)
    @if($selected_graph == 1 || is_null($selected_graph))
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.bundle.min.js"></script>
    <script>
        var ctx = document.getElementById("chart");
        window.onload = function () {
            new Chart(ctx, {
                type: 'line',
                data: {
                    datasets: [{
                        label: 'Actual GPA',
                        data: [
                                @foreach($decisions as $decision)
                                @if($decision->gpa && $decision->gpa < 4)
                            {
                                x: {{ $decision->gpa }},
                                y: @if($decision->decision == 1)
                                    1
                                    @else
                                    0
                                    @endif

                            },
                            @endif
                            @endforeach
                        ]
                    }]
                },
                options: {
                    showLines: false,
                    scales: {
                        xAxes: [{
                            type: 'linear',
                            position: 'bottom'
                        }]
                    }
                }
            });
        }
    </script>
    @endif

    @if($selected_graph == 2)
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.bundle.min.js"></script>
        <script>
            var ctx = document.getElementById("chart");
            window.onload = function () {
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        datasets: [{
                            label: 'GPA',
                            data: [
                                    @foreach($decisions as $decision)
                                    @if($decision->gre_verbal)
                                {
                                    x: {{ $decision->gre_verbal }},
                                    y: @if($decision->decision == 1)
                                        1
                                        @else
                                        0
                                        @endif
                                },
                                @endif
                                @endforeach
                            ]
                        }]
                    },
                    options: {
                        showLines: false,
                        scales: {
                            xAxes: [{
                                type: 'linear',
                                position: 'bottom'
                            }]
                        }
                    }
                });
            }
        </script>
    @endif

    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartist/0.11.0/chartist.min.js"></script>
    <script>
        data = [
                @foreach($decisions as $decision)
                @if($decision->gpa && $decision->gpa < 4)
            {
                x: {{ $decision->gpa }},
                y: {{ $decision->decision }}
            },
            @endif
            @endforeach
        ];

        var options = {
            showLine: false,
            axisX: {
                labelInterpolationFnc: function(value, index) {
                    return index % 13 === 0 ? 'W' + value : null;
                }
            }
        };

        var responsiveOptions = [
            ['screen and (min-width: 640px)', {
                axisX: {
                    labelInterpolationFnc: function(value, index) {
                        return index % 4 === 0 ? 'W' + value : null;
                    }
                }
            }]
        ];

        new Chartist.Line('.ct-chart', data, options, responsiveOptions);
    </script>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-3d.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            // Give the points a 3D feel by adding a radial gradient
            Highcharts.getOptions().colors = $.map(Highcharts.getOptions().colors, function (color) {
                return {
                    radialGradient: {
                        cx: 0.4,
                        cy: 0.3,
                        r: 0.5
                    },
                    stops: [
                        [0, color],
                        [1, Highcharts.Color(color).brighten(-0.2).get('rgb')]
                    ]
                };
            });

            // Set up the chart
            var chart = new Highcharts.Chart({
                chart: {
                    renderTo: '3dcontainer',
                    margin: 100,
                    type: 'scatter',
                    options3d: {
                        enabled: true,
                        alpha: 10,
                        beta: 30,
                        depth: 250,
                        viewDistance: 5,
                        fitToPlot: false,
                        frame: {
                            bottom: {size: 1, color: 'rgba(0,0,0,0.02)'},
                            back: {size: 1, color: 'rgba(0,0,0,0.04)'},
                            side: {size: 1, color: 'rgba(0,0,0,0.06)'}
                        }
                    }
                },
                title: {
                    text: 'Draggable box'
                },
                subtitle: {
                    text: 'Click and drag the plot area to rotate in space'
                },
                plotOptions: {
                    scatter: {
                        width: 10,
                        height: 10,
                        depth: 10
                    }
                },
                yAxis: {
                    min: 130,
                    max: 170,
                    title: 'GRE Verbal'
                },
                xAxis: {
                    min: 130,
                    max: 170,
                    title: 'GRE Quant',
                    gridLineWidth: 1
                },
                zAxis: {
                    min: 0,
                    max: 4,
                    title: 'GPA',
                    showFirstLabel: false
                },
                legend: {
                    enabled: false
                },
                series: [{
                    name: 'Acceptance',
                    color: '#006400',
                    data: {!! $acceptances_3d !!}
                }, {
                    name: 'Rejection',
                    color: '#FF0000',
                    data:  {!! $rejections_3d !!}
                }]
            });


            // Add mouse events for rotation
            $(chart.container).on('mousedown.hc touchstart.hc', function (eStart) {
                eStart = chart.pointer.normalize(eStart);

                var posX = eStart.pageX,
                    posY = eStart.pageY,
                    alpha = chart.options.chart.options3d.alpha,
                    beta = chart.options.chart.options3d.beta,
                    newAlpha,
                    newBeta,
                    sensitivity = 5; // lower is more sensitive

                $(document).on({
                    'mousemove.hc touchdrag.hc': function (e) {
                        // Run beta
                        newBeta = beta + (posX - e.pageX) / sensitivity;
                        chart.options.chart.options3d.beta = newBeta;

                        // Run alpha
                        newAlpha = alpha + (e.pageY - posY) / sensitivity;
                        chart.options.chart.options3d.alpha = newAlpha;

                        chart.redraw(false);
                    },
                    'mouseup touchend': function () {
                        $(document).off('.hc');
                    }
                });
            });
        });

    </script>

    @endif
@endsection

@section('styles')

    <style type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/chartist/0.11.0/chartist.min.css" ></style>

@endsection