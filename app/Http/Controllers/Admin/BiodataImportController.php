<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Biodata;
use App\Models\Department;
use App\Models\CoursesData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BiodataImportController extends Controller
{
    public function showImportForm()
    {
        return view('admin.biodata.import');
    }

    public function import(Request $request)
    {
        // Allow longer run and reduce memory usage
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '512M');
        DB::disableQueryLog();

        $request->validate([
            'file' => [
                'required',
                'file',
                'mimetypes:text/plain,text/csv,application/csv,application/vnd.ms-excel,application/octet-stream',
            ],
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

        // Normalize header to lowercase
        $header = array_map(fn($h) => strtolower(trim($h)), $header);

        // ✅ PRE-LOAD existing keys (admissionno + applno) to avoid duplicates
        $seenKeys = [];

        Biodata::select('admissionno', 'applno')->chunk(2000, function ($rows) use (&$seenKeys) {
            foreach ($rows as $row) {
                $adm   = trim((string) $row->admissionno);
                $appl  = trim((string) $row->applno);
                $key   = $adm . '|' . $appl;
                if ($adm !== '' || $appl !== '') {
                    $seenKeys[$key] = true;
                }
            }
        });

        $batch      = [];
        $batchSize  = 500;
        $inserted   = 0;
        $duplicates = 0;
        $now        = now();

        while (($row = fgetcsv($handle)) !== false) {

            // Skip empty lines
            if (count($row) === 1 && ($row[0] === null || $row[0] === '')) {
                continue;
            }

            // Skip malformed rows (bad column count)
            if (count($row) !== count($header)) {
                continue;
            }

            $data = @array_combine($header, $row);
            if ($data === false) {
                continue;
            }

            // Normalize key fields
            $admissionno = trim($data['admissionno'] ?? '');
            $applno      = trim($data['applno'] ?? '');

            // Build unique key
            $key = $admissionno . '|' . $applno;

            // ✅ Skip duplicates: already in DB or already in this import
            if ($admissionno !== '' || $applno !== '') {
                if (isset($seenKeys[$key])) {
                    $duplicates++;
                    continue;
                }
                // mark as seen
                $seenKeys[$key] = true;
            }

            // Parse dates
            $dob = null;
            if (!empty($data['dob'])) {
                try {
                    $dob = Carbon::parse($data['dob'])->format('Y-m-d');
                } catch (\Exception $e) {
                    $dob = null;
                }
            }

            $dateandtime = null;
            if (!empty($data['dateandtime']) && $data['dateandtime'] !== '0000-00-00 00:00:00') {
                try {
                    $dateandtime = Carbon::parse($data['dateandtime'])->format('Y-m-d H:i:s');
                } catch (\Exception $e) {
                    $dateandtime = null;
                }
            }

            $lastupdate = null;
            if (!empty($data['lastupdate']) && $data['lastupdate'] !== '0000-00-00 00:00:00') {
                try {
                    $lastupdate = Carbon::parse($data['lastupdate'])->format('Y-m-d H:i:s');
                } catch (\Exception $e) {
                    $lastupdate = null;
                }
            }

            // Booleans
            $accountactivated = !empty($data['accountactivated']) ? (bool)$data['accountactivated'] : false;
            $active           = !empty($data['active']) ? (bool)$data['active'] : false;

            // Numeric
            $cautionfeeamt = ($data['cautionfeeamt'] ?? '') !== '' ? (float)$data['cautionfeeamt'] : null;

            $batch[] = [
                'admissionno'        => $admissionno ?: null,
                'studentsname'       => $data['studentsname']      ?? null,
                'emailaddress'       => $data['emailaddress']      ?? null,
                'dob'                => $dob,
                'accountactivated'   => $accountactivated,
                'unlockkey'          => $data['unlockkey']         ?? null,
                'studentpassword'    => $data['studentpassword']   ?? null,
                'studentid'          => $data['studentid']         ?? null,
                'mobileno'           => $data['mobileno']          ?? null,
                'nationalidno'       => $data['nationalidno']      ?? null,
                'birthcertificateno' => $data['birthcertificateno'] ?? null,
                'guardiancell'       => $data['guardiancell']      ?? null,
                'pobox'              => $data['pobox']             ?? null,
                'indexno'            => $data['indexno']           ?? null,
                'townname'           => $data['townname']          ?? null,
                'guardianname'       => $data['guardianname']      ?? null,
                'formerschool'       => $data['formerschool']      ?? null,
                'certificatetype'    => $data['certificatetype']   ?? null,
                'certificateyear'    => $data['certificateyear']   ?? null,
                'gender'             => $data['gender']            ?? null,
                'admlastpart'        => $data['admlastpart']       ?? null,
                'relationship'       => $data['relationship']      ?? null,
                'kcsemeangrade'      => $data['kcsemeangrade']     ?? null,
                'remarks'            => $data['remarks']           ?? null,
                'nextofkinaddress'   => $data['nextofkinaddress']  ?? null,
                'series'             => $data['series']            ?? null,
                'applno'             => $applno ?: null,
                'county'             => $data['county']            ?? null,
                'dateandtime'        => $dateandtime,
                'sponsorid'          => $data['sponsorid']         ?? null,
                'enggrade'           => $data['enggrade']          ?? null,
                'mathgrade'          => $data['mathgrade']         ?? null,
                'phygrade'           => $data['phygrade']          ?? null,
                'district'           => $data['district']          ?? null,
                'officer'            => $data['officer']           ?? null,
                'company'            => $data['company']           ?? null,
                'active'             => $active,
                'cautionfeeamt'      => $cautionfeeamt,
                'lastupdateby'       => $data['lastupdateby']      ?? null,
                'lastupdate'         => $lastupdate,
                'created_at'         => $now,
                'updated_at'         => $now,
            ];

            if (count($batch) >= $batchSize) {
                Biodata::insert($batch);
                $inserted += count($batch);
                $batch = [];
            }
        }

        fclose($handle);

        if (!empty($batch)) {
            Biodata::insert($batch);
            $inserted += count($batch);
        }

        return back()->with(
            'success',
            "Biodata import completed. Inserted {$inserted} records. Skipped {$duplicates} duplicates."
        );
    }

    public function index(Request $request)
    {
        $query = Biodata::query()
            ->with(['admission.course.department']); // <-- nested eager load

        // 🔍 Search
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('studentsname', 'like', "%{$search}%")
                    ->orWhere('studentid', 'like', "%{$search}%")
                    ->orWhere('admissionno', 'like', "%{$search}%")
                    ->orWhere('nationalidno', 'like', "%{$search}%")
                    ->orWhereHas('admission', function ($qa) use ($search) {
                        $qa->where('certno', 'like', "%{$search}%");
                    });
            });
        }

        // 🧭 Filter by department (via course.departmentid)
        if ($departmentId = $request->get('department_id')) {
            $query->whereHas('admission.course', function ($q) use ($departmentId) {
                $q->where('departmentid', $departmentId);
            });
        }

        // 🎓 Filter by course
        if ($courseId = $request->get('course_id')) {
            $query->whereHas('admission.course', function ($q) use ($courseId) {
                $q->where('courseid', $courseId);
            });
        }

        $biodatas = $query->paginate(20)->withQueryString();

        $departments = Department::orderBy('departmentname')->get();
        $courses     = CoursesData::orderBy('coursename')->get();

        return view('admin.biodata.index', compact('biodatas', 'departments', 'courses'));
    }


}
