<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use Illuminate\Http\Request;

class AdmissionController extends Controller
{
    //

    public function dashboard()
    {
        $admission = Admission::where('user_id', auth()->id())->first();

        return view('student.admission.dashboard', compact('admission'));
    }


    public function acceptOffer()
    {
        $admission = Admission::where('user_id', auth()->id())->firstOrFail();

        $admission->update([
            'status' => 'offer_accepted',
            'offer_accepted_at' => now(),
        ]);

        return back()->with('success', 'Offer accepted successfully. Please continue with your admission form.');
    }



}
