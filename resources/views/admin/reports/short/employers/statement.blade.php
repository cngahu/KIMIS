{{--@extends('admin.admin_dashboard')--}}

{{--@section('admin')--}}

{{--    <div class="page-content">--}}

{{--        <h4>Employer Statement: {{ $statement['employer_name'] }}</h4>--}}

{{--        <div class="card mb-4">--}}
{{--            <div class="card-body">--}}
{{--                <strong>Contact Person:</strong> {{ $statement['contact_person'] }} <br>--}}
{{--                <strong>Email:</strong> {{ $statement['email'] }} <br>--}}
{{--                <strong>Phone:</strong> {{ $statement['phone'] }} <br>--}}
{{--                <strong>Address:</strong>--}}
{{--                {{ $statement['address'] }}, {{ $statement['town'] }}, {{ $statement['county'] }}--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <a href="{{ route('reports.short.employer.statement.pdf', urlencode($statement['employer_name'])) }}"--}}
{{--           class="btn btn-success mb-3" target="_blank">--}}
{{--            Download PDF--}}
{{--        </a>--}}

{{--        <div class="card">--}}
{{--            <div class="card-body">--}}

{{--                <table class="table table-bordered table-striped">--}}
{{--                    <thead class="table-dark">--}}
{{--                    <tr>--}}
{{--                        <th>Training</th>--}}
{{--                        <th>Participants</th>--}}
{{--                        <th>Invoice</th>--}}
{{--                        <th>Amount</th>--}}
{{--                        <th>Paid</th>--}}
{{--                        <th>Balance</th>--}}
{{--                        <th>Status</th>--}}
{{--                    </tr>--}}
{{--                    </thead>--}}

{{--                    <tbody>--}}
{{--                    @foreach($statement['trainings'] as $t)--}}
{{--                        <tr>--}}
{{--                            <td>--}}
{{--                                {{ $t['course_name'] }} <br>--}}
{{--                                <small>{{ $t['start_date'] }} → {{ $t['end_date'] }}</small>--}}
{{--                            </td>--}}

{{--                            <td>--}}
{{--                                {{ $t['participants_count'] }}--}}
{{--                            </td>--}}

{{--                            <td>{{ $t['invoice_number'] ?? '-' }}</td>--}}
{{--                            <td>KSh {{ number_format($t['amount'], 2) }}</td>--}}
{{--                            <td class="text-success">KSh {{ number_format($t['paid'], 2) }}</td>--}}
{{--                            <td class="text-danger">KSh {{ number_format($t['balance'], 2) }}</td>--}}
{{--                            <td>{{ ucfirst($t['status']) }}</td>--}}
{{--                        </tr>--}}
{{--                    @endforeach--}}
{{--                    </tbody>--}}

{{--                    <tfoot>--}}
{{--                    <tr class="fw-bold">--}}
{{--                        <td colspan="3" class="text-end">TOTALS</td>--}}
{{--                        <td>KSh {{ number_format($statement['totals']['expected'], 2) }}</td>--}}
{{--                        <td class="text-success">KSh {{ number_format($statement['totals']['paid'], 2) }}</td>--}}
{{--                        <td class="text-danger">KSh {{ number_format($statement['totals']['pending'], 2) }}</td>--}}
{{--                        <td></td>--}}
{{--                    </tr>--}}
{{--                    </tfoot>--}}

{{--                </table>--}}

{{--            </div>--}}
{{--        </div>--}}

{{--    </div>--}}

{{--@endsection--}}
@extends('admin.admin_dashboard')

@section('admin')

    <style>
        .statement-card {
            border: 1px solid #dcdcdc;
            border-radius: 8px;
            padding: 20px;
            background: #ffffff;
        }
        .statement-header {
            text-align: center;
            margin-bottom: 25px;
        }
        .statement-header img {
            width: 90px;
            margin-bottom: 10px;
        }
        .statement-title {
            font-weight: bold;
            font-size: 22px;
            color: #0a3d62;
            margin-bottom: 5px;
        }
        .statement-subtitle {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 10px;
        }
        .table thead th {
            background: #0a3d62 !important;
            color: #fff;
        }
        .section-title {
            font-weight: bold;
            font-size: 18px;
            margin-top: 25px;
            margin-bottom: 10px;
            color: #0a3d62;
        }
        .totals-row {
            font-weight: bold;
            background: #f0f0f0;
        }
    </style>

    <div class="row justify-content-center mb-4">
        <div class="col-lg-10">

            <div class="statement-card">

                <!-- HEADER -->
                <div class="statement-header">
                    <img src="{{ asset('logo/kihbt_logo.png') }}">
                    <div class="statement-title">KENYA INSTITUTE OF HIGHWAYS & BUILDING TECHNOLOGY</div>
                    <div class="statement-subtitle">Employer Training Account Statement</div>
                    <small>Generated on: {{ now()->format('d M Y H:i') }}</small>
                </div>

                <!-- EMPLOYER DETAILS -->
                <div class="section-title">Employer Information</div>

                <table class="table table-bordered">
                    <tr>
                        <th width="30%">Employer Name</th>
                        <td>{{ $statement['employer_name'] }}</td>
                    </tr>
                    <tr>
                        <th>Contact Person</th>
                        <td>{{ $statement['contact_person'] }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $statement['email'] }}</td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td>{{ $statement['phone'] }}</td>
                    </tr>
                    <tr>
                        <th>Postal Address</th>
                        <td>{{ $statement['address'] }}, {{ $statement['town'] }}, {{ $statement['county'] }}</td>
                    </tr>
                </table>

                <!-- TRAINING SUMMARY -->
                <div class="section-title">Training & Payment Summary</div>

                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Training</th>
                        <th>Schedule</th>
                        <th>Participants</th>
                        <th>Invoice</th>
                        <th>Amount</th>
                        <th>Paid</th>
                        <th>Balance</th>
                        <th>Status</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($statement['trainings'] as $row)
                        <tr>
                            <td>{{ $row['course_name'] }}</td>
                            <td>{{ $row['start_date'] }} → {{ $row['end_date'] }}</td>
                            <td class="text-center">{{ $row['participants_count'] }}</td>
                            <td class="text-center">{{ $row['invoice_number'] ?? '-' }}</td>
                            <td class="text-end">KSh {{ number_format($row['amount'], 2) }}</td>
                            <td class="text-end text-success">KSh {{ number_format($row['paid'], 2) }}</td>
                            <td class="text-end text-danger">KSh {{ number_format($row['balance'], 2) }}</td>
                            <td class="text-center">{{ ucfirst($row['status']) }}</td>
                        </tr>

                        <!-- PARTICIPANTS BLOCK -->
                        <tr>
                            <td colspan="8">
                                <strong>Participants:</strong>

                                <table class="table table-bordered mt-2" style="background:#fafafa;">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>ID Number</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($row['participants'] as $p)
                                        <tr>
                                            <td>{{ $p->full_name }}</td>
                                            <td>{{ $p->id_no }}</td>
                                            <td>{{ $p->phone }}</td>
                                            <td>{{ $p->email }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </td>
                        </tr>

                    @endforeach
                    </tbody>

                    <tfoot>
                    <tr class="totals-row">
                        <td colspan="4" class="text-end">TOTALS</td>
                        <td class="text-end">KSh {{ number_format($statement['totals']['expected'], 2) }}</td>
                        <td class="text-end text-success">KSh {{ number_format($statement['totals']['paid'], 2) }}</td>
                        <td class="text-end text-danger">KSh {{ number_format($statement['totals']['pending'], 2) }}</td>
                        <td></td>
                    </tr>
                    </tfoot>

                </table>

                <!-- DOWNLOAD PDF BUTTON -->
                <div class="text-center mt-4">
                    <a href="{{ route('reports.short.employer.statement.pdf', ['employer' => $statement['employer_name']]) }}"
                       target="_blank"
                       class="btn btn-success btn-lg">
                        <i class="bx bx-download"></i> Download PDF Statement
                    </a>
                </div>

            </div>

        </div>
    </div>

@endsection
