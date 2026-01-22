@extends('layouts.public')

@section('content')
    <section class="container py-5">

        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="card shadow-sm mb-4">
                    <div class="card-body">

                        <h4 class="fw-bold mb-2">
                            Application: {{ $application->reference }}
                        </h4>

                        <p class="mb-1">
                            <strong>Training:</strong>
                            {{ optional($application->training)->name }}
                        </p>

                        <p class="mb-1">
                            <strong>Total Participants:</strong>
                            {{ $application->total_participants }}
                        </p>

                        <hr>

                        <div class="alert {{ $balance <= 0 ? 'alert-success' : 'alert-warning' }}">
                            Outstanding Balance:
                            <strong>KES {{ number_format($balance, 2) }}</strong>
                        </div>

                        @if($balance > 0)
                            <form method="POST" action="{{ route('payments.create.short') }}">
                                @csrf

                                <input type="hidden" name="application_id"
                                       value="{{ $application->id }}">

                                <div class="mb-3">
                                    <label class="form-label">
                                        Enter Amount to Pay
                                    </label>
                                    <input type="number"
                                           name="amount"
                                           min="1"
                                           max="{{ $balance }}"
                                           class="form-control"
                                           required>
                                </div>

                                <button class="btn btn-primary btn-lg w-100">
                                    Proceed to Payment
                                </button>
                            </form>
                        @else
                            <p class="text-success fw-bold">
                                ✔ This application is fully paid.
                            </p>
                        @endif

                    </div>
                </div>

                {{-- Optional: Ledger preview --}}
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">Payment History</h6>

                        <table class="table table-sm">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th class="text-end">Debit</th>
                                <th class="text-end">Credit</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($ledger as $row)
                                <tr>
                                    <td>{{ $row->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $row->description }}</td>
                                    <td class="text-end">
                                        {{ $row->entry_type === 'debit' ? number_format($row->amount,2) : '' }}
                                    </td>
                                    <td class="text-end">
                                        {{ $row->entry_type === 'credit' ? number_format($row->amount,2) : '' }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

    </section>
@endsection
