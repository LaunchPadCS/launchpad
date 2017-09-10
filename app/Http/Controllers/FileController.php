<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function exportHashids()
    {
        $applicants = Applicant::where('interview_slot_id', 0)->get();
        \Excel::create('LaunchPad Export', function ($excel) use ($applicants) {

            // Set the title
            $excel->setTitle('LaunchPad Applicants and Hashids');

            // Chain the setters
            $excel->setCreator('LaunchPad')
                  ->setCompany('LaunchPad');

            $excel->sheet('list', function ($sheet) use ($applicants) {
                foreach ($applicants as $applicant) {
                    $sheet->appendRow([
                        $applicant->firstname, $applicant->lastname, $applicant->email, 'https://launchpadcs.org/interview/'.$applicant->hashid,
                    ]);
                }
            });
        })->download('xls');
    }

    public function exportDecisionList(Request $request) {
        if($request->decision != 0 && $request->decision != 1) {
            return "invalid decision";
        }
        if($request->decision) {
            $string = "Accepted";
        } else {
            $string = "Denied";
        }

        $applicants = Applicant::where('decision', $request->decision)->get();
        \Excel::create('LaunchPad '. $string .' Export', function ($excel) use ($applicants, $string) {

            // Set the title
            $excel->setTitle('LaunchPad '. $string .'Applicants');

            // Chain the setters
            $excel->setCreator('LaunchPad')
                  ->setCompany('LaunchPad');

            $excel->sheet($string, function ($sheet) use ($applicants) {
                foreach ($applicants as $applicant) {
                    $sheet->appendRow([
                        $applicant->firstname, $applicant->lastname, $applicant->email, 'https://launchpadcs.org/invite/'.$applicant->hashid,
                    ]);
                }
            });
        })->download('xls');
    }

    public function exportSheet(Request $request) {
    	if($request->group != "mentee" && $request->group != "mentor") {
    		return "bad group";
    	}
    	$data = User::whereHas(
            'roles', function($q) use ($request) {
                $q->where('name', $request->group);
            }
        )->get(['name', 'tagline', 'image', 'fb', 'website', 'github', 'about', 'instagram', 'snapchat']);
    	$pdf = \PDF::loadView('pdfs.sheet', compact('data'));
		return $pdf->stream();
    }
}