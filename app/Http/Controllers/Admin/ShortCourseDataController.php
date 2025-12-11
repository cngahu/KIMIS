<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShortCourseData;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        // Allow big imports
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '512M');
        DB::disableQueryLog();

        $request->validate([
            'file' => ['required', 'file', 'mimes:csv,txt,xls,xlsx'],
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

        // ✅ Preload existing (classno, coursecode, studentid) combos to avoid per-row DB queries
        $existingKeys = [];

        ShortCourseData::select('classno', 'coursecode', 'studentid')
            ->chunk(2000, function ($rows) use (&$existingKeys) {
                foreach ($rows as $row) {
                    $key = trim((string)$row->classno) . '|' .
                        trim((string)$row->coursecode) . '|' .
                        trim((string)$row->studentid);

                    $existingKeys[$key] = true;
                }
            });

        $batch     = [];
        $batchSize = 500; // adjust as needed

        while (($row = fgetcsv($handle)) !== false) {

            // Skip completely empty lines
            if (count($row) === 1 && ($row[0] === null || $row[0] === '')) {
                continue;
            }

            // Guard against malformed rows
            if (count($row) !== count($header)) {
                continue;
            }

            // Combine header -> value
            $data = @array_combine($header, $row);
            if ($data === false) {
                // Malformed row: skip
                continue;
            }

            // Normalize key fields for duplicate check
            $classno    = trim($data['classno']    ?? '');
            $coursecode = trim($data['coursecode'] ?? '');
            $studentid  = trim($data['studentid']  ?? '');

            // Build unique key string
            $key = $classno . '|' . $coursecode . '|' . $studentid;

            // 🔍 Skip duplicates based on (classno, coursecode, studentid)
            if ($classno !== '' && $coursecode !== '' && $studentid !== '') {
                if (isset($existingKeys[$key])) {
                    $duplicates++;
                    continue;
                }

                // mark as seen (so later rows in this upload also skip)
                $existingKeys[$key] = true;
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

            // Add to batch instead of inserting row-by-row
            $batch[] = [
                'classno'         => $classno ?: null,
                'departmentname'  => $data['departmentname']  ?? null,
                'coursecode'      => $coursecode ?: null,
                'coursename'      => $data['coursename']      ?? null,
                'venue'           => $data['venue']           ?? null,
                'classname'       => $data['classname']       ?? null,
                'startdate'       => $startdate,
                'enddate'         => $enddate,
                'studyactualyear' => $data['studyactualyear'] ?? null,
                'studyterm'       => $data['studyterm']       ?? null,
                'studentid'       => $studentid ?: null,
                'studentsname'    => $data['studentsname']    ?? null,
                'gender'          => $data['gender']          ?? null,
                'company'         => $data['company']         ?? null,
                'certno'          => $data['certno']          ?? null,
                'mobileno'        => $data['mobileno']        ?? null,
                'nationalidno'    => $data['nationalidno']    ?? null,
                'emailaddress'    => $data['emailaddress']    ?? null,
                'county'          => $data['county']          ?? null,
                'officer'         => $data['officer']         ?? null,
                'created_at'      => now(),
                'updated_at'      => now(),
            ];

            // If batch is full, insert it
            if (count($batch) >= $batchSize) {
                ShortCourseData::insert($batch);
                $inserted += count($batch);
                $batch = [];
            }
        }

        fclose($handle);

        // Insert any remaining rows
        if (!empty($batch)) {
            ShortCourseData::insert($batch);
            $inserted += count($batch);
        }

        return back()->with(
            'success',
            "Import completed. Inserted {$inserted} records. Skipped {$duplicates} duplicates."
        );
    }}
