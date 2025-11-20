@extends('admin.admin_dashboard')

@section('admin')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts/dist/apexcharts.css">

    <style>
        .section-header {
            font-size: 18px;
            font-weight: bold;
            color: #003366;
            margin-top: 35px;
            margin-bottom: 10px;
        }
        .card-analytic {
            border-radius: 12px;
            border: none;
            box-shadow: 0 3px 8px rgba(0,0,0,0.07);
        }
    </style>

    <div class="page-content">

        <h4 class="mb-3">Admissions Analytics Dashboard</h4>

        <!-- ===== STAT CARDS ===== -->
        <div class="row">
            @include('admin.registrar.dashboard.widgets.stats')
        </div>

        <!-- ===== APPLICATION TRENDS ===== -->
        <div class="section-header">Application Trends</div>
        <div class="row">
            <div class="col-md-6">
                <div class="card card-analytic">
                    <div class="card-body">
                        <h6>Applications in Last 30 Days</h6>
                        <div id="dailyTrendChart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-analytic">
                    <div class="card-body">
                        <h6>Course Popularity</h6>
                        <div id="courseChart"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== DISTRIBUTIONS ===== -->
        <div class="section-header">Applicant Distributions</div>
        <div class="row">
            <div class="col-md-4">
                <div class="card card-analytic">
                    <div class="card-body">
                        <h6>Gender Breakdown</h6>
                        <div id="genderChart" style="height: 260px;"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-analytic">
                    <div class="card-body">
                        <h6>Financier Breakdown</h6>
                        <div id="financierChart" style="height: 260px;"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-analytic">
                    <div class="card-body">
                        <h6>KCSE Mean Grade Distribution</h6>
                        <div id="gradeChart"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== OFFICER PERFORMANCE ===== -->
        <div class="section-header">Officer Performance Leaderboard</div>
        <div class="card card-analytic">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Officer</th>
                        <th>Applications Handled</th>
                        <th>Avg Processing Time (Hours)</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($leaderboard as $row)
                        <tr>
                            <td>{{ $row->reviewer->surname }} {{ $row->reviewer->firstname }}</td>
                            <td>{{ $row->handled }}</td>
                            <td>{{ number_format($row->avg_hours, 1) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        /** DAILY TREND **/
        new ApexCharts(document.querySelector("#dailyTrendChart"), {
            chart: { type: 'area', height: 300, toolbar: { show: false }},
            stroke: { curve: 'smooth' },
            dataLabels: { enabled: false },
            series: [{
                name: "Applications",
                data: @json($daily->pluck('total'))
            }],
            xaxis: {
                categories: @json($daily->pluck('day')),
            }
        }).render();

        /** GENDER **/
        new ApexCharts(document.querySelector("#genderChart"), {
            chart: { type: 'donut', height: 260 },
            labels: @json($genderCounts->keys()),
            series: @json($genderCounts->values()),
        }).render();

        /** FINANCIER **/
        new ApexCharts(document.querySelector("#financierChart"), {
            chart: { type: 'pie', height: 260 },
            labels: @json($financiers->keys()),
            series: @json($financiers->values()),
        }).render();

        /** GRADES **/
        new ApexCharts(document.querySelector("#gradeChart"), {
            chart: { type: 'bar' },
            series: [{
                name: 'Applicants',
                data: @json($grades->values())
            }],
            xaxis: {
                categories: @json($grades->keys())
            }
        }).render();
    </script>

@endsection
