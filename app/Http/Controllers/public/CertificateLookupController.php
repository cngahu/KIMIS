<?php

namespace App\Http\Controllers\public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CertData;

class CertificateLookupController extends Controller
{
    public function verify(Request $request)
    {
        $certNo = trim((string) $request->input('cert_no', ''));
        $record = null;

        if ($certNo !== '') {
            // Case-insensitive, ignore spaces
            $clean = preg_replace('/\s+/', '', $certNo);

            $record = CertData::whereRaw("REPLACE(CERT_NO, ' ', '') = ?", [$clean])
                ->first();
        }

        return view('public.certificate_verify', [
            'query'  => $certNo,
            'record' => $record,
        ]);
    }
}
