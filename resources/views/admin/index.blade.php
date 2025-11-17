@extends('admin.admin_dashboard')
@section('admin')

    <style>
        .kpi-value { font-weight: 700; font-size: 1.45rem; }
        .kpi-label { font-weight: 600; font-size: .95rem; }
        .kpi-change { font-weight: 600; }
        .table thead th { font-weight: 700 !important; font-size: .9rem; }
        .table tbody td { font-weight: 500; }
        .applicant-name { font-weight: 600; }
        .course-name { font-weight: 600; font-size: .85rem; }
        .toolbar-label { font-weight: 600; font-size: .8rem; text-transform: uppercase; color:#6b7280; }
    </style>

    <div class="page-content">

        {{-- KPI CARDS --}}
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-3">

            {{-- Total Applicants --}}
            <div class="col">
                <div class="card radius-10" style="background:linear-gradient(135deg,#3b2818,#5a3b23);">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0 text-white kpi-value">{{ $totalApplicants ?? '1,254' }}</h5>
                            <div class="ms-auto"><i class='bx bx-user-plus fs-3 text-white'></i></div>
                        </div>
                        <div class="progress my-3 bg-light-transparent" style="height:3px;">
                            <div class="progress-bar bg-white" role="progressbar" style="width: 70%"></div>
                        </div>
                        <div class="d-flex align-items-center text-white kpi-label">
                            <p class="mb-0">Total Applicants</p>
                            <p class="mb-0 ms-auto kpi-change">
                                +6.3% <i class='bx bx-up-arrow-alt'></i>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- New Applications Today --}}
            <div class="col">
                <div class="card radius-10" style="background:linear-gradient(135deg,#f9a90f,#ffcc4d);">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0 text-white kpi-value">{{ $todayApplications ?? '48' }}</h5>
                            <div class="ms-auto"><i class='bx bx-file fs-3 text-white'></i></div>
                        </div>
                        <div class="progress my-3 bg-light-transparent" style="height:3px;">
                            <div class="progress-bar bg-white" role="progressbar" style="width: 55%"></div>
                        </div>
                        <div class="d-flex align-items-center text-white kpi-label">
                            <p class="mb-0">New Applications Today</p>
                            <p class="mb-0 ms-auto kpi-change">
                                +2.1% <i class='bx bx-up-arrow-alt'></i>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Admitted Students --}}
            <div class="col">
                <div class="card radius-10" style="background:linear-gradient(135deg,#2b9348,#4bb368);">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0 text-white kpi-value">{{ $admittedStudents ?? '862' }}</h5>
                            <div class="ms-auto"><i class='bx bx-user-check fs-3 text-white'></i></div>
                        </div>
                        <div class="progress my-3 bg-light-transparent" style="height:3px;">
                            <div class="progress-bar bg-white" role="progressbar" style="width: 60%"></div>
                        </div>
                        <div class="d-flex align-items-center text-white kpi-label">
                            <p class="mb-0">Admitted Students</p>
                            <p class="mb-0 ms-auto kpi-change">
                                +3.8% <i class='bx bx-up-arrow-alt'></i>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pending Payments --}}
            <div class="col">
                <div class="card radius-10" style="background:linear-gradient(135deg,#c0392b,#e74c3c);">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0 text-white kpi-value">{{ $pendingPayments ?? '139' }}</h5>
                            <div class="ms-auto"><i class='bx bx-credit-card fs-3 text-white'></i></div>
                        </div>
                        <div class="progress my-3 bg-light-transparent" style="height:3px;">
                            <div class="progress-bar bg-white" role="progressbar" style="width: 45%"></div>
                        </div>
                        <div class="d-flex align-items-center text-white kpi-label">
                            <p class="mb-0">Pending Payments</p>
                            <p class="mb-0 ms-auto kpi-change">
                                -1.4% <i class='bx bx-down-arrow-alt'></i>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- end row -->


        {{-- RECENT APPLICATIONS + FILTERS + QUICK ACTIONS --}}
        <div class="card radius-10 mt-3">
            <div class="card-body">

                {{-- Header + filter toolbar + export --}}
                <div class="d-flex flex-column flex-md-row align-items-md-center mb-2 gap-3">

                    <div class="flex-grow-1">
                        <h5 class="mb-0 fw-bold">Recent Applications</h5>
                        <small class="text-muted fw-semibold">Latest applicant submissions for review</small>
                    </div>

                    {{-- Filters (static for now, can wire later) --}}
                    <form method="GET" action="#" class="d-flex flex-wrap gap-2">
                        <div>
                            <label class="toolbar-label mb-1 d-block">Status</label>
                            <select name="status" class="form-select form-select-sm">
                                <option value="">All</option>
                                <option value="submitted">Submitted</option>
                                <option value="under_review">Under Review</option>
                                <option value="admitted">Admitted</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                        <div>
                            <label class="toolbar-label mb-1 d-block">Intake</label>
                            <select name="intake" class="form-select form-select-sm">
                                <option value="">All</option>
                                <option value="jan-2025">Jan 2025</option>
                                <option value="may-2025">May 2025</option>
                            </select>
                        </div>
                        <div>
                            <label class="toolbar-label mb-1 d-block">Search</label>
                            <input type="text" name="q" class="form-control form-control-sm"
                                   placeholder="Name / App ID">
                        </div>
                        <div class="align-self-end">
                            <button type="submit" class="btn btn-sm btn-outline-secondary fw-semibold">
                                Filter
                            </button>
                        </div>
                    </form>

                    {{-- Export buttons (dummy links for now) --}}
                    <div class="ms-md-3 d-flex flex-wrap gap-2">
                        <a href="javascript:void(0);" class="btn btn-sm btn-outline-success fw-semibold">
                            <i class="bx bx-file"></i> Excel
                        </a>
                        <a href="javascript:void(0);" class="btn btn-sm btn-outline-danger fw-semibold">
                            <i class="bx bx-file"></i> PDF
                        </a>
                    </div>

                </div>

                <hr>

                {{-- Quick actions row --}}
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                    <div class="toolbar-label">
                        Quick Actions
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <button type="button" class="btn btn-sm btn-success fw-semibold">
                            <i class="bx bx-check-circle"></i> Approve Selected
                        </button>
                        <button type="button" class="btn btn-sm btn-warning fw-semibold">
                            <i class="bx bx-x-circle"></i> Reject Selected
                        </button>
                        <button type="button" class="btn btn-sm btn-primary fw-semibold">
                            <i class="bx bx-envelope"></i> Message Applicant
                        </button>
                    </div>
                </div>

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                        <tr>
                            <th>
                                <input type="checkbox" id="selectAllApps">
                            </th>
                            <th>Application ID</th>
                            <th>Applicant</th>
                            <th>Course</th>
                            <th>Intake</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        {{-- Static sample data (replace with @foreach from DB later) --}}
                        <tr>
                            <td>
                                <input type="checkbox" class="app-row-checkbox">
                            </td>
                            <td class="fw-semibold">#APP-00125</td>
                            <td class="applicant-name">Jane Mwangi</td>
                            <td class="course-name">Diploma in Highway Engineering</td>
                            <td>Jan 2025</td>
                            <td>14 Nov 2024</td>
                            <td>
                            <span class="badge rounded-pill bg-light-warning text-warning w-100 fw-semibold">
                                Under Review
                            </span>
                            </td>
                            <td class="text-center">
                                <a href="javascript:void(0);" class="text-primary" title="View">
                                    <i class="bx bx-show"></i>
                                </a>
                                <a href="javascript:void(0);" class="ms-3 text-secondary" title="Edit">
                                    <i class="bx bx-edit"></i>
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <input type="checkbox" class="app-row-checkbox">
                            </td>
                            <td class="fw-semibold">#APP-00126</td>
                            <td class="applicant-name">Peter Otieno</td>
                            <td class="course-name">Certificate in Building Technology</td>
                            <td>Jan 2025</td>
                            <td>14 Nov 2024</td>
                            <td>
                            <span class="badge rounded-pill bg-light-success text-success w-100 fw-semibold">
                                Admitted
                            </span>
                            </td>
                            <td class="text-center">
                                <a href="javascript:void(0);" class="text-primary" title="View">
                                    <i class="bx bx-show"></i>
                                </a>
                                <a href="javascript:void(0);" class="ms-3 text-secondary" title="Edit">
                                    <i class="bx bx-edit"></i>
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <input type="checkbox" class="app-row-checkbox">
                            </td>
                            <td class="fw-semibold">#APP-00127</td>
                            <td class="applicant-name">Faith Achieng</td>
                            <td class="course-name">Diploma in Civil Engineering</td>
                            <td>May 2025</td>
                            <td>15 Nov 2024</td>
                            <td>
                            <span class="badge rounded-pill bg-light-info text-info w-100 fw-semibold">
                                Submitted
                            </span>
                            </td>
                            <td class="text-center">
                                <a href="javascript:void(0);" class="text-primary" title="View">
                                    <i class="bx bx-show"></i>
                                </a>
                                <a href="javascript:void(0);" class="ms-3 text-secondary" title="Edit">
                                    <i class="bx bx-edit"></i>
                                </a>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{-- CHART: APPLICATIONS OVERVIEW --}}
        <div class="row mt-4">
            <div class="col-12 col-xl-7 mb-3">
                <div class="card radius-10 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <h5 class="mb-0 fw-bold">Applications by Month</h5>
                            <span class="badge bg-light text-muted ms-2">Last 12 Months</span>
                        </div>
                        <small class="text-muted fw-semibold d-block mb-3">
                            Total applications received per month
                        </small>
                        <div style="height:260px;">
                            <canvas id="applicationsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Status summary --}}
            <div class="col-12 col-xl-5 mb-3">
                <div class="card radius-10 h-100">
                    <div class="card-body">
                        <h5 class="mb-0 fw-bold">Summary by Status</h5>
                        <small class="text-muted fw-semibold d-block mb-3">Current intake snapshot</small>

                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-semibold">Submitted</span>
                            <span class="badge bg-light-info text-info fw-semibold">120</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-semibold">Under Review</span>
                            <span class="badge bg-light-warning text-warning fw-semibold">85</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-semibold">Admitted</span>
                            <span class="badge bg-light-success text-success fw-semibold">64</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-semibold">Rejected</span>
                            <span class="badge bg-light-danger text-danger fw-semibold">18</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>

    {{-- Chart + bulk checkbox JS --}}
    <script>
        // === Chart: Applications by Month (static sample data for now) ===
        const chartLabels = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        const chartData   = [35, 40, 32, 48, 55, 60, 70, 68, 62, 58, 50, 45];

        if (typeof Chart !== 'undefined') {
            const ctx = document.getElementById('applicationsChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Applications',
                        data: chartData,
                        backgroundColor: 'rgba(59,40,24,0.85)',
                        borderRadius: 6,
                        maxBarThickness: 26,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: { mode: 'index', intersect: false }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { font: { weight: '600' } }
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(0,0,0,0.06)' },
                            ticks: { font: { weight: '600' } }
                        }
                    }
                }
            });
        }

        // === Select all checkboxes ===
        document.getElementById('selectAllApps')?.addEventListener('change', function () {
            const checked = this.checked;
            document.querySelectorAll('.app-row-checkbox').forEach(cb => cb.checked = checked);
        });
    </script>

@endsection
