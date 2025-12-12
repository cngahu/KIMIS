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
            color: #333;
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
            background: #f0f0f0 !important;
        }
    </style>

    <div class="row justify-content-center mb-4">
        <div class="col-lg-10">

            <div class="statement-card">

                <!-- HEADER -->
                <div class="statement-header">
                    <img src="{{ asset('logo/kihbt_logo.png') }}">
                    <div class="statement-title">KENYA INSTITUTE OF HIGHWAYS & BUILDING TECHNOLOGY</div>
                    <div class="statement-subtitle">Student Fee Statement</div>
                    <small>Generated on: {{ now()->format('d M Y H:i') }}</small>
                </div>

                <!-- STUDENT DETAILS -->
                <div class="section-title">Student Information</div>

                <table class="table table-bordered">
                    <tr>
                        <th width="30%">Student Name</th>
                        <td>{{ $admission->application->full_name }}</td>
                    </tr>
                    <tr>
                        <th>Admission Number</th>
                        <td>{{ $admission->admission_no ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Course</th>
                        <td>{{ $admission->application->course->course_name }}</td>
                    </tr>
                </table>

                <!-- SUMMARY -->
                <div class="section-title">Fee Summary</div>

                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th width="40%">Total Fee Required</th>
                        <td>KSh {{ number_format($requiredFee, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Total Paid</th>
                        <td class="text-success">KSh {{ number_format($paidTotal, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Balance</th>
                        <td class="{{ $balance > 0 ? 'text-danger' : 'text-success' }}">
                            KSh {{ number_format($balance, 2) }}
                        </td>
                    </tr>
                    </tbody>
                </table>

                <!-- PAYMENTS -->
                <div class="section-title">Payment History</div>

                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Invoice No.</th>
                        <th>Amount Paid</th>
                        <th>Payment Channel</th>
                        <th>Date Paid</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($payments as $p)
                        <tr>
                            <td>{{ $p->invoice->invoice_number }}</td>
                            <td class="text-end">KSh {{ number_format($p->amount, 2) }}</td>
                            <td>{{ ucfirst($p->invoice->payment_channel ?? 'Unknown') }}</td>
                            <td>{{ optional($p->invoice->paid_at)->format('d M Y, H:i') }}</td>
                        </tr>
                    @endforeach
                    </tbody>

                    <tfoot>
                    <tr class="totals-row">
                        <td class="text-end">TOTALS</td>
                        <td class="text-end">KSh {{ number_format($paidTotal, 2) }}</td>
                        <td colspan="2"></td>
                    </tr>
                    </tfoot>

                </table>

                <!-- PDF DOWNLOAD BUTTON -->
                <div class="text-center mt-4">
                    <a href="{{ route('student.fee.statement.pdf') }}"
                       target="_blank"
                       class="btn btn-success btn-lg">
                        <i class="bx bx-download"></i> Download PDF Statement
                    </a>
                </div>

            </div>

        </div>
    </div>

@endsection
