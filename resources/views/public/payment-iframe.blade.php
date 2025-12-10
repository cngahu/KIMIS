@extends('layouts.public')

@section('content')
    @php




    @endphp
    <form action="https://test.pesaflow.com/PaymentAPI/iframev2.1.php" method="post" target="my_iframe">
        <input type="hidden" name="secureHash" value="{{ $my_secureHash }}">
        <input type="hidden" name="apiClientID" value="{{ $apiClientID }}">
        <input type="hidden" name="sendSTK" value="True">
        <input type="hidden" name="format" value="iframe">
        <input type="hidden" name="billDesc" value="{{ $billDesc }}">
        <input type="hidden" name="billRefNumber" value="{{ $billRefNumber }}">
        <input type="hidden" name="currency" value="KES">
        <input type="hidden" name="serviceID" value="{{ $serviceID }}">
        <input type="hidden" name="clientMSISDN" value="{{ $clientMSISDN }}">
        <input type="hidden" name="clientName" value="{{ $clientName }}">
        <input type="hidden" name="clientIDNumber" value="{{ $clientIDNumber }}">
        <input type="hidden" name="clientEmail" value="{{ $clientEmail }}">
        <input type="hidden" name="callBackURLOnSuccess" value="{{ $callBackURLOnSuccess }}">
        <input type="hidden" name="notificationURL" value="{{ $notificationURL }}">
        <input type="hidden" name="amountExpected" value="{{ $amountExpected }}">
        <button type="submit" class="btn btn-primary">Initiate Payment</button>
    </form>

    <iframe name="my_iframe" style="width:100%;height:700px;border:0;margin-top:10px;"></iframe>


@endsection
