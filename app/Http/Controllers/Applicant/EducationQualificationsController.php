<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Models\country;
use App\Models\educationqualifications;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EducationQualificationsController extends Controller
{
    //

    public function PrimaryEducation(){

        $userid=Auth::user()->id;
        $country=DB::table('countries')->select('name','id')->get();
        return view('applicant.apply.education_primary',compact('userid','country'));



    }

    public function SecondaryEducation(){
        $userid=Auth::user()->id;
        $country=DB::table('countries')->select('name','id')->get();
        return view('applicant.apply.education_secondary',compact('userid','country'));



    }

    public function PostSecondaryEducation(){
        $userid=Auth::user()->id;
        $country=DB::table('countries')->select('name','id')->get();

        $postsecondary=educationqualifications::where('userid',$userid)->where(function ($q) {
            $q->where('academiclevel', "Diploma")->orWhere('academiclevel', "Degree");
        })->get();
        if(count($postsecondary)>0)
        {
            return view('applicant.apply.all_postsecondary',compact('userid','postsecondary'));

        }
        else
        {
            return view('applicant.apply.education_postsecondary',compact('userid','country'));

        }





    }
    public function PrimaryEducationStore(Request $request){

        $request->validate([
            'certificate'=>'required|mimes:pdf'
        ],
            [
                'certificate.mimes:pdf'=>'Please Upload A PDF Document',
            ]

        );

        $this->SaveEducationDetails($request,"Primary",3);
        $notification = array(
            'message' => 'Primary Education Qualification Saved Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('applicant.secondaryeducation')->with($notification);


    }

    public function SecondaryEducationStore(Request $request){

        $request->validate([
            'certificate'=>'required|mimes:pdf'
        ],
            [
                'certificate.mimes:pdf'=>'Please Upload A PDF Document',
            ]

        );

           $this->SaveEducationDetails($request,"Secondary",4);
        $notification = array(
            'message' => 'Secondary Education Qualification Saved Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('applicant.postsecondaryeducation')->with($notification);


    }

    public function PostSecondaryEducationStore(Request $request){

        $request->validate([
            'certificate'=>'required|mimes:pdf'
        ],
            [
                'certificate.mimes:pdf'=>'Please Upload A PDF Document',
            ]

        );

        $this->SaveEducationDetails($request,$request->category,5);
        $notification = array(
            'message' => 'Post Secondary Education Qualification Saved Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('applicant.postsecondaryeducation')->with($notification);


    }

    public function SaveEducationDetails(Request $request, $acedmiclevel,$level){

        $educationid= educationqualifications::insertGetId([

            'userid' => $request->userid,
            'academiclevel' => $acedmiclevel,
            'startDate' => $request->startDate,
            'exitDate' => $request->exitDate,
            'institutionName' => $request->institutionName,
            'country' => $request->country_id,
            'course_name' => $request->course_name,
            'institution_contact' => $request->institution_contact,
            'grade' => $request->grade,
//            'certNo' => $request->certNo,
            'certificate' => "",
            'entryDate' => Carbon::now(),
            'created_at'=>Carbon::now(),
        ]);


        if($request->certificate != null) {
            $certificate ='EQ-'. $educationid . '.' . $request->certificate->extension();
            $request->certificate->move(public_path('upload/educationqual/'), $certificate);
            $certificate_url = 'upload/educationqual/' . $certificate;
        }
        else{
            $certificate_url=null;
        }
        $eduprofile=EducationQualifications::findOrFail($educationid);
        $eduprofile->certificate=$certificate_url;
        $eduprofile->save();
        $user=User::find($request->userid);
        $user->level=$level;
        $user->save();
    }

    public function ProfileSummary()
    {

        $userid=User::find(Auth::user()->id);
        $educationquals=educationqualifications::where('userid',Auth::user()->id)->get();
        return view('applicant.apply.applicationsummary',compact('userid','educationquals'));

    }
}
