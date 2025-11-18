<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Http\Requests\CountyRequest;
use App\Services\Lookups\CountyService;

use App\Models\County;

class CountyController extends Controller
{
    //
    protected CountyService $service;

    public function __construct(CountyService $service)
    {
        $this->service = $service;

        // Permission middleware
        $this->middleware('permission:county.view')->only(['index']);
        $this->middleware('permission:county.create')->only(['create', 'store']);
        $this->middleware('permission:county.edit')->only(['edit', 'update']);
        $this->middleware('permission:county.delete')->only(['destroy']);
    }

    /** List counties */
    public function index()
    {
        $counties = County::orderBy('name')->paginate(60);
        return view('backend.counties.index', compact('counties'));
    }

    /** Show create form */
    public function create()
    {
        return view('backend.counties.create');
    }

    /** Store county */
    public function store(CountyRequest $request)
    {
        $county = $this->service->store($request->validated());

        return redirect()
            ->route('backend.counties.index')
            ->with('success', 'County created successfully.');
    }

    /** Edit form */
    public function edit(County $county)
    {
        return view('backend.counties.edit', compact('county'));
    }

    /** Update county */
    public function update(CountyRequest $request, County $county)
    {
        $this->service->update($county, $request->validated());

        return redirect()
            ->route('backend.counties.index')
            ->with('success', 'County updated successfully.');
    }

    /** Delete county */
    public function destroy(County $county)
    {
        $this->service->destroy($county);

        return redirect()
            ->route('backend.counties.index')
            ->with('success', 'County deleted successfully.');
    }
}
