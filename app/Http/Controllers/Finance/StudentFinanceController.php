<?php

namespace App\Http\Controllers\Finance;


use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\StudentLedger;
use App\Services\Finance\StudentLedgerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentFinanceController extends Controller
{
    protected StudentLedgerService $ledger;

    public function __construct(StudentLedgerService $ledger)
    {
        $this->ledger = $ledger;
    }

    /**
     * Search students
     */
    public function index0(Request $request)
    {
        $students = Student::query()
            ->when($request->q, function ($q) use ($request) {
                $q->where('student_number', 'like', "%{$request->q}%");
            })
            ->limit(50)
            ->get();

        return view('finance.students.index', compact('students'));
    }

    public function index1(Request $request)
    {
        $query = DB::table('student_ledgers as l')
            ->leftJoin('students as s', 's.id', '=', 'l.student_id')
            ->leftJoin('masterdata as m', 'm.id', '=', 'l.masterdata_id')
            ->selectRaw('
            COALESCE(s.id, m.id) as subject_id,
            s.id as student_id,
            m.id as masterdata_id,
            COALESCE(s.student_number, m.admissionNo) as admission_no
        ')
            ->groupBy('subject_id', 'student_id', 'masterdata_id', 'admission_no');

        if ($request->q) {
            $query->where(function ($q) use ($request) {
                $q->where('s.student_number', 'like', "%{$request->q}%")
                    ->orWhere('m.admissionNo', 'like', "%{$request->q}%");
            });
        }

        $subjects = $query->limit(50)->get();

        return view('finance.students.index', compact('subjects'));
    }
    public function index(Request $request)
    {
        $query = DB::table('student_ledgers as l')

            ->leftJoin('students as s', function ($join) {
                $join->on('s.id', '=', 'l.ledger_owner_id')
                    ->where('l.ledger_owner_type', '=', \App\Models\Student::class);
            })

            ->leftJoin('masterdata as m', function ($join) {
                $join->on('m.id', '=', 'l.ledger_owner_id')
                    ->where('l.ledger_owner_type', '=', \App\Models\Masterdata::class);
            })

            ->leftJoin('short_training_applications as sta', function ($join) {
                $join->on('sta.id', '=', 'l.ledger_owner_id')
                    ->where('l.ledger_owner_type', '=', \App\Models\ShortTrainingApplication::class);
            })

            ->select([
                'l.ledger_owner_type',
                'l.ledger_owner_id',

                DB::raw("
            CASE
                WHEN l.ledger_owner_type = '".addslashes(\App\Models\Student::class)."'
                    THEN s.student_number
                WHEN l.ledger_owner_type = '".addslashes(\App\Models\Masterdata::class)."'
                    THEN m.admissionNo
                WHEN l.ledger_owner_type = '".addslashes(\App\Models\ShortTrainingApplication::class)."'
                    THEN sta.reference
            END as account_reference
        "),

                DB::raw("
            CASE
                WHEN l.ledger_owner_type = '".addslashes(\App\Models\Student::class)."'
                    THEN 'Student'
                WHEN l.ledger_owner_type = '".addslashes(\App\Models\Masterdata::class)."'
                    THEN 'Legacy Student'
                WHEN l.ledger_owner_type = '".addslashes(\App\Models\ShortTrainingApplication::class)."'
                    THEN 'Short Course'
            END as account_type
        "),
            ])
            ->groupBy(
                'l.ledger_owner_type',
                'l.ledger_owner_id',
                'account_reference',
                'account_type'
            );

        // -----------------------------
        // SEARCH
        // -----------------------------
        if ($request->q) {
            $query->where(function ($q) use ($request) {
                $q->where('s.student_number', 'like', "%{$request->q}%")
                    ->orWhere('m.admissionNo', 'like', "%{$request->q}%")
                    ->orWhere('sta.reference', 'like', "%{$request->q}%");
            });
        }

        $accounts = $query->limit(50)->get();

        return view('finance.students.index', compact('accounts'));
    }

    /**
     * View ledger
     */
    public function show(Student $student)
    {
        $ledger = $this->ledger->getLedger($student);
        $balance = $this->ledger->computeBalance($student);

        return view('finance.students.ledger', compact(
            'student',
            'ledger',
            'balance'
        ));
    }

    /**
     * Manual debit
     */
    public function debit0(Request $request, Student $student)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'category' => 'required',
            'description' => 'required',
        ]);

        $this->ledger->postDebit($student, $request->all());

        return back()->with('success', 'Debit posted successfully.');
    }

    /**
     * Manual credit
     */
    public function credit0(Request $request, Student $student)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'category' => 'required',
            'description' => 'required',
        ]);

        $this->ledger->postCredit($student, $request->all());

        return back()->with('success', 'Credit posted successfully.');
    }
    public function showLedger(Request $request)
    {
        $studentId = $request->get('student_id');
        $masterdataId = $request->get('masterdata_id');

        if (!$studentId && !$masterdataId) {
            abort(404);
        }

        $ledger = StudentLedger::where(function ($q) use ($studentId, $masterdataId) {
            if ($studentId) {
                $q->where('student_id', $studentId);
            }
            if ($masterdataId) {
                $q->orWhere('masterdata_id', $masterdataId);
            }
        })->orderBy('created_at')->get();

        // Compute balance safely
        $balance = $ledger->reduce(function ($carry, $row) {
            return $row->entry_type === 'debit'
                ? $carry + $row->amount
                : $carry - $row->amount;
        }, 0);

        return view('finance.students.ledger', compact(
            'ledger',
            'balance',
            'studentId',
            'masterdataId'
        ));
    }

    public function debit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'description' => 'required',
            'category' => 'required',
        ]);

        $studentId = $request->student_id;
        $masterdataId = $request->masterdata_id;

        StudentLedger::create([
            'student_id'    => $studentId,
            'masterdata_id' => $masterdataId,

            'entry_type'  => 'debit',
            'category'    => $request->category,
            'amount'      => $request->amount,

            'provisional' => false,
            'source'      => 'manual',
            'description' => $request->description,
            'created_by'  => auth()->id(),
        ]);

        return back()->with('success', 'Debit posted successfully.');
    }

    public function credit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'description' => 'required',
            'category' => 'required',
        ]);

        $studentId = $request->student_id;
        $masterdataId = $request->masterdata_id;

        StudentLedger::create([
            'student_id'    => $studentId,
            'masterdata_id' => $masterdataId,

            'entry_type'  => 'credit',
            'category'    => $request->category,
            'amount'      => $request->amount,

            'provisional' => false,
            'source'      => 'manual',
            'description' => $request->description,
            'created_by'  => auth()->id(),
        ]);

        return back()->with('success', 'Credit posted successfully.');
    }

}

