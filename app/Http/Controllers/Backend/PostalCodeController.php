<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\PostalCodeRequest;
use App\Models\PostalCode;
use App\Services\Lookups\PostalCodeService;
class PostalCodeController extends Controller
{
    //
    protected PostalCodeService $service;

    public function __construct(PostalCodeService $service)
    {
        $this->service = $service;

        $this->middleware('permission:postal_codes.view')->only('index');
        $this->middleware('permission:postal_codes.create')->only(['create', 'store']);
        $this->middleware('permission:postal_codes.edit')->only(['edit', 'update']);
        $this->middleware('permission:postal_codes.delete')->only(['destroy']);
    }

    public function index()
    {
        $postalCodes = PostalCode::orderBy('code')->paginate(50);
        return view('backend.postal_codes.index', compact('postalCodes'));
    }

    public function create()
    {
        return view('backend.postal_codes.create');
    }

    public function store(PostalCodeRequest $request)
    {
        $this->service->store($request->validated());

        return redirect()->route('backend.postal_codes.index')
            ->with('success', 'Postal code added successfully.');
    }

    public function edit(PostalCode $postal_code)
    {
        return view('backend.postal_codes.edit', compact('postal_code'));
    }

    public function update(PostalCodeRequest $request, PostalCode $postal_code)
    {
        $this->service->update($postal_code, $request->validated());

        return redirect()->route('backend.postal_codes.index')
            ->with('success', 'Postal code updated successfully.');
    }

    public function destroy(PostalCode $postal_code)
    {
        $this->service->destroy($postal_code);

        return redirect()->route('backend.postal_codes.index')
            ->with('success', 'Postal code deleted successfully.');
    }
}
