<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdmissionRecord;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdmissionRecordImportController extends Controller
{
    /**
     * Show upload form.
     */
    public function showImportForm()
    {
        return view('admin.admissions.import');
    }

    /**
     * Import CSV into admissionsrecord table.
     */
    public function import(Request $request)
    {
        // 1. Allow long-running import & reduce memory overhead
        ini_set('max_execution_time', 0);   // no time limit for this request
        ini_set('memory_limit', '512M');    // adjust if needed
        DB::disableQueryLog();              // avoid storing all queries in memory

        $request->validate([
            'file' => ['required', 'file', 'mimes:csv,txt'],
        ]);

        $path = $request->file('file')->getRealPath();

        if (($handle = fopen($path, 'r')) === false) {
            return back()->with('error', 'Could not open uploaded file.');
        }

        $header = fgetcsv($handle);

        if (!$header) {
            fclose($handle);
            return back()->with('error', 'The uploaded file is empty or invalid.');
        }

        // Normalize headers
        $header = array_map(fn($h) => strtolower(trim($h)), $header);

        $batch      = [];
        $batchSize  = 500; // insert 500 rows at a time
        $inserted   = 0;
        $now        = now();

        while (($row = fgetcsv($handle)) !== false) {

            // Skip completely empty lines
            if (count($row) === 1 && ($row[0] === null || $row[0] === '')) {
                continue;
            }

            $data = @array_combine($header, $row);
            if ($data === false) {
                continue; // malformed row, skip
            }

            // Parse numeric fields safely
            $admissionid = isset($data['admissionid']) ? (int) $data['admissionid'] : null;
            $studentid   = isset($data['studentid']) ? (int) $data['studentid'] : null;
            $courseid    = isset($data['courseid']) ? (int) $data['courseid'] : null;
            $studyyearid = isset($data['studyyearid']) ? (int) $data['studyyearid'] : null;

            $meanpoints  = $data['meanpoints']  !== '' ? (float) $data['meanpoints']  : null;
            $meanmarks   = $data['meanmarks']   !== '' ? (float) $data['meanmarks']   : null;

            // Boolean flags (0/1)
            $cancelresults = !empty($data['cancelresults']) ? (bool) $data['cancelresults'] : false;
            $boarder       = !empty($data['boarder'])       ? (bool) $data['boarder']       : false;
            $refered       = !empty($data['refered'])       ? (bool) $data['refered']       : false;
            $found         = !empty($data['found'])         ? (bool) $data['found']         : false;

            // admissiondate (avoid invalid "0000-00-00 00:00:00")
            $admissiondate = null;
            if (!empty($data['admissiondate']) && $data['admissiondate'] !== '0000-00-00 00:00:00') {
                try {
                    $admissiondate = Carbon::parse($data['admissiondate'])->format('Y-m-d H:i:s');
                } catch (\Exception $e) {
                    $admissiondate = null;
                }
            }

            // Build one row for batch insert
            $batch[] = [
                'admissionid'   => $admissionid,
                'studentid'     => $studentid,
                'courseid'      => $courseid,
                'studyyearid'   => $studyyearid,
                'meanpoints'    => $meanpoints,
                'meangrade'     => $data['meangrade']      ?? null,
                'meanmarks'     => $meanmarks,
                'overallgrade'  => $data['overallgrade']   ?? null,
                'modifiedby'    => $data['modifiedby']     ?? null,
                'cancelresults' => $cancelresults,
                'admissiondate' => $admissiondate,
                'streamid'      => isset($data['streamid']) ? (int) $data['streamid'] : null,
                'boarder'       => $boarder,
                'refered'       => $refered,
                'found'         => $found,
                'certno'        => $data['certno']         ?? null,
                'username'      => $data['username']       ?? null,
                'created_at'    => $now,
                'updated_at'    => $now,
            ];

            // If batch full, insert and reset
            if (count($batch) >= $batchSize) {
                AdmissionRecord::insert($batch);
                $inserted += count($batch);
                $batch = [];
            }
        }

        fclose($handle);

        // Insert any remaining rows
        if (!empty($batch)) {
            AdmissionRecord::insert($batch);
            $inserted += count($batch);
        }

        return back()->with('success', "Import completed. Inserted {$inserted} records.");
    }
}
