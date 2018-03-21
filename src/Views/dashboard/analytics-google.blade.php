@extends('cms::layouts.dashboard')

@section('pageTitle') Dashboard @stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <canvas id="dashboardChart" class="raw100"></canvas>
            </div>

            <div class="row raw-margin-top-24">
                <div class="col-md-4">
                    <p class="lead">Keywords</p>
                    <table class="table table-striped">
                        <thead>
                            <th>Keyword</th>
                            <th>Sessions</th>
                        </thead>
                        @foreach (LaravelAnalytics::getTopKeywords(365, 10) as $word)
                            <tr>
                                <td>{{ $word['keyword'] }}</td>
                                <td>{{ $word['sessions'] }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="col-md-4">
                    <p class="lead">Most Visited Pages</p>
                    <table class="table table-striped">
                        <thead>
                            <th>URL</th>
                            <th>Views</th>
                        </thead>
                        @foreach (LaravelAnalytics::getMostVisitedPages(365, 10) as $browser)
                            <tr>
                                <td>{{ str_limit($browser['url'], 30) }}</td>
                                <td>{{ $browser['pageViews'] }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="col-md-4">
                    <p class="lead">Top Referers</p>
                    <table class="table table-striped">
                        <thead>
                            <th>URL</th>
                            <th>Views</th>
                        </thead>
                        @foreach (LaravelAnalytics::getTopReferrers(365, 10) as $referers)
                            <tr>
                                <td>{{ str_limit($referers['url'], 30) }}</td>
                                <td>{{ $referers['pageViews'] }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>

        </div>
    </div>

@stop

@section('javascript')
    @parent
    <script type="text/javascript">
        var _chartData = {
            _labels : {!! json_encode($visitStats['date']) !!},
            _visits : {!! json_encode($visitStats['pageViews']) !!}
        };
        var options = {};
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.bundle.js"></script>
    {!! Minify::javascript(Cms::asset('js/dashboard-chart.js')) !!}
@stop