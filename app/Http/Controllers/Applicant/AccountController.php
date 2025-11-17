<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Models\gender;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    //
    public function Register(){
        $user=User::where('id', Auth::user()->id)->first();
        $user=User::where('id', Auth::user()->id)->first();
        $titles=DB::table('titles')->select('id','name')->get();
        $gender=DB::table('genders')->select('id','name')->get();
        $nationalities=DB::table('countries')->select('id','name')->get();
$counties=DB::table('counties')->select('id','name')->get();
        $county=DB::table('counties')->select('id','name')->get();

        return view('applicant.apply.account',compact('counties','user','nationalities','county','titles','gender'));

    }

    public function RegisterUpdate(Request $request){

        $request->validate([

                'national_id' => 'required|mimes:pdf|max:100000',
               'photo' => 'required|image|mimes:jpg,png,jpeg|max:2048',
                'dob'=>'before:today'


            ],
            [
                'dob'=>'The Date of Birth Date must be before today',

            ]
        );


        if ($request->file('national_id')) {
            $national_id = $request->userid.time().'.'.$request->national_id->extension();
            $request->national_id->move(public_path('upload/national_id/'), $national_id);
            $national_id_url='upload/national_id/'.$national_id;
        }
        else
        {
          $national_id_url = "";
        }

        if ($request->file('photo')) {
            $file = $request->file('photo');

            $filename =$request->userid.date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'),$filename);
            $photourl = $filename;
        }
        else
        {
            $photourl = "";
        }


        User::findOrFail($request->userid)->update([

            'surname' =>strtoupper($request->surname),
            'firstname' =>strtoupper( $request->firstname),
            'othername' => strtoupper($request->othername),
            'photo' =>$photourl,
            'phone' => $request->phone,
            'address' =>strtoupper( $request->address),
            'physical_address' => strtoupper($request->physical_address),
            'city' => $request->city,
            'title_id' => $request->title_id ,
            'gender_id' => $request->gender_id ,
            'country_id' => $request->country_id,
            'dob' => $request->dob,
            'national_id' =>$national_id_url,
            'nationality' => $request->nationality,
            'nationalid' => $request->nationalid,
            'county' => $request->county,
            'next_of_kin' => strtoupper($request->next_of_kin),
            'next_of_kin_contact' => $request->next_of_kin_contact,

            'level' => 2,
            'updated_at' => Carbon::now(),
        ]);
        $notification = array(
            'message' => 'Personal Details Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('applicant.dashboard')->with($notification);

    }
}
