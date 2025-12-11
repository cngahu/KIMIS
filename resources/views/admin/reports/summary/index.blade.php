@extends('admin.admin_dashboard')

@section('admin')

    <div class="page-content">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold">Applications Summary Dashboard</h4>

            <a href="{{ route('reports.summary.pdf', request()->query()) }}"
               class="btn btn-success" target="_blank">
                <i class="bx bxs-file-pdf"></i> Download PDF
            </a>
        </div>


        <!-- ===========================
                SUMMARY CARDS
        ============================ -->
        <div class="row g-3 mb-4">

            <div class="col-md-3">
                <div class="card text-white" style="background:#003366;">
                    <div class="card-body">
                        <h5 class="card-title">Total Applications</h5>
                        <h2>{{ $applications->count() }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h5 class="card-title">Approved</h5>
                        <h2>{{ $statusCounts['approved'] ?? 0 }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-white bg-danger">
                    <div class="card-body">
                        <h5 class="card-title">Rejected</h5>
                        <h2>{{ $statusCounts['rejected'] ?? 0 }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <h5 class="card-title">Pending Payment</h5>
                        <h2>{{ $statusCounts['pending_payment'] ?? 0 }}</h2>
                    </div>
                </div>
            </div>

        </div>


        <!-- ===========================
                CHARTS ROW
        ============================ -->
        <div class="row g-4 mb-4">

            <!-- Status Pie Chart -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header fw-bold">Applications by Status</div>
                    <div class="card-body">
                        <canvas id="statusChart" height="200"></canvas>
                    </div>
                </div>
            </div>

            <!-- Age Distribution -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header fw-bold">Age Group Distribution</div>
                    <div class="card-body">
                        <canvas id="ageChart" height="200"></canvas>
                    </div>
                </div>
            </div>

        </div>


        <!-- ===========================
                COUNTY DISTRIBUTION TABLE
        ============================ -->
        <div class="card shadow-sm mb-4">
            <div class="card-header fw-bold">Applications by Home County</div>
            <div class="card-body p-0">
                <table class="table table-striped table-bordered mb-0">
                    <thead class="table-dark">
                    <tr>
                        <th>County</th>
                        <th>Applications</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($homeCountyStats as $row)
                        <tr>
                            <td>{{ optional($row->homeCounty)->name ?? 'Unknown' }}</td>
                            <td>{{ $row->total }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>


        <!-- ===========================
                COURSE DISTRIBUTION TABLE
        ============================ -->
        <div class="card shadow-sm">
            <div class="card-header fw-bold">Applications by Course</div>
            <div class="card-body p-0">
                <table class="table table-striped table-bordered mb-0">
                    <thead class="table-dark">
                    <tr>
                        <th>Course</th>
                        <th>Applications</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($courseStats as $row)
                        <tr>
                            <td>{{ optional($row->course)->course_name }}</td>
                            <td>{{ $row->total }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>


    </div>



    <!-- ===========================
            CHART JS
    ============================ -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // STATUS CHART
        const statusChart = new Chart(document.getElementById('statusChart'), {
            type: 'pie',
            data: {
                labels: {!! json_encode(array_keys($statusCounts->toArray())) !!},
                datasets: [{
                    data: {!! json_encode(array_values($statusCounts->toArray())) !!},
                    backgroundColor: ['#003366','#28a745','#dc3545','#ffc107','#6c757d']
                }]
            }
        });

        // AGE CHART
        const ageChart = new Chart(document.getElementById('ageChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($ageGroups)) !!},
                datasets: [{
                    label: "Applicants",
                    data: {!! json_encode(array_values($ageGroups)) !!},
                    backgroundColor: '#003366'
                }]
            },
            options: { responsive: true, scales: { y: { beginAtZero: true } } }
        });

    </script>

@endsection
