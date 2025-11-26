@extends('admin.admin_dashboard')
@section('admin')
    @php

        $convenience=50;
       $Serviceid="";
        $serviceID=48460;
       $total=50000 + $convenience;
           $curl = curl_init();
       $clientMSISDN = '0700123456';

       $clientEmail = 'canjetan.ngahu@icta.go.ke';


       $callBackURLOnSuccess = 'https://portal.pck.go.ke/applicant/dashboard';
       $notificationURL = "https://portal.pck.go.ke/api/pesaflow/confirm";

       $apiClientID = '35';
       //$apiClientID = '317';
       //$amountExpected = $total;
            $amountExpected = 1;
       $serviceIDd = $serviceID;
       $clientIDNumber = 'A12345678';
       $currency = "KES";
       //    $billRefNumber = "KFCB123131";
       $billRefNumber = 'PCK2024001';
       $billDesc = 'KIBI TEST PAYMENT';
       $clientName ='Canjetan Ngahu';
       $secret = "7UiF90LT3RkIkala3FAxcwzYEXiy8Ztw";
       $key = "Fhtuo4tuMATrqmtL";
       $stk=true;
       $format='iframe';

       $data_string = "$apiClientID"."$amountExpected"."$serviceID"."$clientIDNumber"."$currency"."$billRefNumber"."$billDesc"     . "$clientName"."$secret";
       // Step 2 hash the values
       $hash = hash_hmac('sha256', $data_string, $key);
       // Step 3 encode
       $my_secureHash = base64_encode($hash);



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
