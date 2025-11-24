<!DOCTYPE html>
<html>
<head>
    <title>Simulate Payment</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f6f8fa; }
        .card { background: white; padding: 20px; border-radius: 8px; width: 400px; margin: auto; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
        input, button { width: 100%; padding: 10px; margin-top: 10px; }
        button { background: #007bff; color: white; border: none; cursor: pointer; }
        button:hover { background: #0056b3; }
        h2 { margin-bottom: 10px; }
    </style>
</head>
<body>

<div class="card">
    <h2>Simulate Payment</h2>

    <form method="POST" action="{{ route('simulate.payment') }}">
        @csrf

        <label>Invoice ID</label>
        <input type="number" name="invoice_id" required>

        <label>Amount Paid</label>
        <input type="number" name="amount_paid" step="0.01" required>

        <label>Payment Reference (optional)</label>
        <input type="text" name="reference" placeholder="SIM-XXXXXX">

        <button type="submit">Simulate Payment</button>
    </form>
</div>

</body>
</html>
