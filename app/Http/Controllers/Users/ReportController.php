<?php

namespace App\Http\Controllers\Users;

use App\PatientReport;
use Carbon\Carbon;
use Facade\FlareClient\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    //

    public function store(Request $request){
        //dd($request->all());
        $request->validate([
            'uid' => 'required|',
            'Conid' => 'required|',
            'report' => 'required|file|mimes:pdf,doc,docx,odt'
        ],[
            'uid.required' => 'Patient id is required.',
            'Conid.required' => 'Consultation id is required.',

            'report.required' => 'Report file is required.',
            'report.file' => 'Report file must be a file.',
            'report.mimes' => 'Report file can only contain pdf, odt, docx and doc file.',
        ]);

        if($request->hasFile('report')) {
            $get_image = $request->file('report'); // get the image form post method...
            $fileNameWithExt = $get_image->getClientOriginalName(); // get full file name ...
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME); // get only the file name without extension ....
            $extension = $get_image->getClientOriginalExtension();// get the file extension

            $allowed_Ext = array('pdf', 'docx', 'doc', 'odt');
            if (in_array(strtolower($extension), $allowed_Ext, true) == false) {
                return back()->withErrors('Error', 'Report file can only contain pdf, odt, docx and doc file.');
            }
            $newFileName = $fileName . '-' . time() . '.' . $extension; // Ste the file name to store in the database ....

            $Location = '/public/user_data/patient/report/';
            $get_image->storeAs($Location, $newFileName); // set the storage path ...
            $StorageLink = '/storage/user_data/patient/report/' . $newFileName;
        }

        PatientReport::Insert([
            'user_id' => $this->decryptID($request->uid),
            'doctor_id' => Auth::user()->doctor->id,
            'consultation_id' => $this->decryptID($request->Conid),
            'report_file' => $StorageLink,
            'created_at' => Carbon::now()
        ]);

        return redirect()->back()->with('Success', 'Report successfully sent to patient.');
    }
}
