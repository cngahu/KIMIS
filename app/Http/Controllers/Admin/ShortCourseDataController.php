<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShortCourseData;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ShortCourseDataController extends Controller
{
    /**
     * Optional: list imported short course data.
     */
    public function index()
    {
        $records = ShortCourseData::orderBy('startdate', 'desc')->paginate(50);

        return view('admin.shortcourses.index', compact('records'));
    }

    /**
     * Show the CSV upload form.
     */
    public function showImportForm()
    {
        return view('admin.shortcourses.import');
    }

    /**
     * Handle CSV upload and import into shortcoursedata table.
     * Skips duplicates based on (classno, coursecode, studentid).
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:csv,txt'],
        ]);

        $path = $request->file('file')->getRealPath();

        // Open CSV file
        if (($handle = fopen($path, 'r')) === false) {
            return back()->with('error', 'Could not open uploaded file.');
        }

        // Read header row
        $header = fgetcsv($handle);

        if (!$header) {
            fclose($handle);
            return back()->with('error', 'The uploaded file appears to be empty or invalid.');
        }

        // Normalize header: lowercase, trimmed
        $header = array_map(fn($h) => strtolower(trim($h)), $header);

        /**
         * Expected headers (case-insensitive):
         * classno, departmentname, coursecode, coursename,
         * venue, classname, startdate, enddate, studyactualyear,
         * studyterm, studentid, studentsname, gender, company,
         * certno, mobileno, nationalidno, emailaddress, county, officer
         */

        $inserted   = 0;
        $duplicates = 0;

        while (($row = fgetcsv($handle)) !== false) {

            // Skip completely empty lines
            if (count($row) === 1 && ($row[0] === null || $row[0] === '')) {
                continue;
            }

            // Combine header -> value
            $data = @array_combine($header, $row);
            if ($data === false) {
                // Malformed row: skip
                continue;
            }

            // Normalize key fields for duplicate check
            $classno    = $data['classno']    ?? null;
            $coursecode = $data['coursecode'] ?? null;
            $studentid  = $data['studentid']  ?? null;

            // 🔍 1. Duplicate check based on (classno, coursecode, studentid)
            if ($classno && $coursecode && $studentid) {
                $exists = ShortCourseData::where('classno', $classno)
                    ->where('coursecode', $coursecode)
                    ->where('studentid', $studentid)
                    ->exists();

                if ($exists) {
                    $duplicates++;
                    continue; // skip this row
                }
            }

            // 2. Parse dates (CSV like "02-02-15 12:00")
            $startdate = null;
            $enddate   = null;

            if (!empty($data['startdate'])) {
                try {
                    $startdate = Carbon::createFromFormat('d-m-y H:i', trim($data['startdate']))
                        ->format('Y-m-d');
                } catch (\Exception $e) {
                    $startdate = null;
                }
            }

            if (!empty($data['enddate'])) {
                try {
                    $enddate = Carbon::createFromFormat('d-m-y H:i', trim($data['enddate']))
                        ->format('Y-m-d');
                } catch (\Exception $e) {
                    $enddate = null;
                }
            }

            // 3. Create record
            ShortCourseData::create([
                'classno'         => $classno,
                'departmentname'  => $data['departmentname']  ?? null,
                'coursecode'      => $coursecode,
                'coursename'      => $data['coursename']      ?? null,
                'venue'           => $data['venue']           ?? null,
                'classname'       => $data['classname']       ?? null,
                'startdate'       => $startdate,
                'enddate'         => $enddate,
                'studyactualyear' => $data['studyactualyear'] ?? null,
                'studyterm'       => $data['studyterm']       ?? null,
                'studentid'       => $studentid,
                'studentsname'    => $data['studentsname']    ?? null,
                'gender'          => $data['gender']          ?? null,
                'company'         => $data['company']         ?? null,
                'certno'          => $data['certno']          ?? null,
                'mobileno'        => $data['mobileno']        ?? null,
                'nationalidno'    => $data['nationalidno']    ?? null,
                'emailaddress'    => $data['emailaddress']    ?? null,
                'county'          => $data['county']          ?? null,
                'officer'         => $data['officer']         ?? null,
            ]);

            $inserted++;
        }

        fclose($handle);

        return back()->with(
            'success',
            "Import completed. Inserted {$inserted} records. Skipped {$duplicates} duplicates."
        );
    }
}
