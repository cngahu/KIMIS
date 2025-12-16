<?php

namespace App\Http\Controllers\Admin;

use App\Imports\MasterdataImport;
use App\Http\Controllers\Controller;
use App\Models\Masterdata;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MasterdataController extends Controller
{
    public function index()
    {
        $rows = Masterdata::latest()->paginate(25);
        return view('admin.masterdata.index', compact('rows'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv'],
        ]);

        $import = new MasterdataImport();
        Excel::import($import, $request->file('file'));

        $failures = $import->failures();

        return redirect()->route('masterdata.index')
            ->with('success', 'Import completed successfully.')
            ->with('failures', $failures);
    }

    /** Delete all masterdata */
    public function truncate()
    {
        Masterdata::truncate();

        return redirect()
            ->route('masterdata.index')
            ->with('success', 'All masterdata has been deleted.');
    }
}
