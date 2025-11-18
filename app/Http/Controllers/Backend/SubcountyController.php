<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\SubcountyRequest;
use App\Models\County;
use App\Models\Subcounty;
use App\Services\Lookups\SubcountyService;
class SubcountyController extends Controller
{
    //
    protected SubcountyService $service;

    public function __construct(SubcountyService $service)
    {
        $this->service = $service;

        $this->middleware('permission:subcounty.view')->only(['index']);
        $this->middleware('permission:subcounty.create')->only(['create', 'store']);
        $this->middleware('permission:subcounty.edit')->only(['edit', 'update']);
        $this->middleware('permission:subcounty.delete')->only(['destroy']);
    }

    public function index()
    {
        $subcounties = Subcounty::with('county')->orderBy('name')->paginate(20);
        return view('backend.subcounties.index', compact('subcounties'));
    }

    public function create()
    {
        $counties = County::orderBy('name')->get();
        return view('backend.subcounties.create', compact('counties'));
    }

    public function store(SubcountyRequest $request)
    {
        $this->service->store($request->validated());

        return redirect()
            ->route('backend.subcounties.index')
            ->with('success', 'Subcounty created successfully.');
    }

    public function edit(Subcounty $subcounty)
    {
        $counties = County::orderBy('name')->get();
        return view('backend.subcounties.edit', compact('subcounty','counties'));
    }

    public function update(SubcountyRequest $request, Subcounty $subcounty)
    {
        $this->service->update($subcounty, $request->validated());

        return redirect()
            ->route('backend.subcounties.index')
            ->with('success', 'Subcounty updated successfully.');
    }

    public function destroy(Subcounty $subcounty)
    {
        $this->service->destroy($subcounty);

        return redirect()
            ->route('backend.subcounties.index')
            ->with('success', 'Subcounty deleted successfully.');
    }
}
