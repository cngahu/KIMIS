<?php

namespace App\Http\Controllers\public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CertData;
use App\Models\ShortCourseData;

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

    public function showForm(Request $request)
    {
        $result = null;
        $error  = null;

        // We only search when there is input
        if ($request->filled('certno') || $request->filled('nationalidno')) {

            $request->validate([
                'certno'       => ['nullable', 'string', 'max:255'],
                'nationalidno' => ['nullable', 'string', 'max:255'],
            ]);

            $query = ShortCourseData::query();

            if ($request->filled('certno')) {
                $query->where('certno', trim($request->certno));
            }

            if ($request->filled('nationalidno')) {
                // If both are filled, this will be an AND condition
                $query->where('nationalidno', trim($request->nationalidno));
            }

            $result = $query->first();

            if (!$result) {
                $error = 'No matching record found for the provided details.';
            }
        }

        return view('public.certificates.verify', [
            'result' => $result,
            'error'  => $error,
        ]);
    }
}
