<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\User;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function exportHashids()
    {
        $applicants = Applicant::where('interview_slot_id', 0)->get();
        \Excel::create(env('APP_NAME').'Export', function ($excel) use ($applicants) {

            // Set the title
            $excel->setTitle(env('APP_NAME').' Applicants and Hashids');

            // Chain the setters
            $excel->setCreator(env('APP_NAME'))
                  ->setCompany(env('APP_NAME'));

            $excel->sheet('list', function ($sheet) use ($applicants) {
                foreach ($applicants as $applicant) {
                    $sheet->appendRow([
                        $applicant->firstname, $applicant->lastname, $applicant->email, env('APP_URL').'/interview/'.$applicant->hashid,
                    ]);
                }
            });
        })->download('xls');
    }

    public function exportDecisionList(Request $request)
    {
        if ($request->decision != 0 && $request->decision != 1) {
            return 'invalid decision';
        }
        $applicants = Applicant::where('decision', $request->decision);
        if ($request->decision) {
            $string = 'Accepted';
            $applicants->orWhere('decision', 2);
        } else {
            $string = 'Denied';
        }

        $applicants = $applicants->get();
        \Excel::create(env('APP_NAME').' '.$string.' Export', function ($excel) use ($applicants, $string) {

            // Set the title
            $excel->setTitle(env('APP_NAME').' '.$string.'Applicants');

            // Chain the setters
            $excel->setCreator(env('APP_NAME'))
                  ->setCompany(env('APP_NAME'));

            $excel->sheet($string, function ($sheet) use ($applicants) {
                foreach ($applicants as $applicant) {
                    $sheet->appendRow([
                        $applicant->firstname, $applicant->lastname, $applicant->email, env('APP_URL').'/invite/'.$applicant->hashid,
                    ]);
                }
            });
        })->download('xls');
    }

    public function exportSheet(Request $request)
    {
        if ($request->group != 'mentee' && $request->group != 'mentor') {
            return 'bad group';
        }
        $data = User::whereHas(
            'roles', function ($q) use ($request) {
                $q->where('name', $request->group);
            }
        )->get(['name', 'tagline', 'image', 'fb', 'website', 'github', 'about', 'instagram', 'snapchat']);
        $client = new \GuzzleHttp\Client();
        foreach ($data as $user) {
            if ($user->snapchat) {
                if (!file_exists(storage_path('app/public').'/snap/'.$user->snapchat)) {
                    $resource = fopen(storage_path('app/public').'/snap/'.$user->snapchat, 'w+');
                    $client->request('GET', 'https://feelinsonice.appspot.com/web/deeplink/snapcode?username='.$user->snapchat.'&size=500&type=PNG', ['sink' => $resource]);
                }
            }
        }
        if (\Cache::store('file')->has($request->group)) {
            return response()->file(storage_path('app/public').'/pdfs/'.$request->group.'.pdf');
        } else {
            $pdf = \PDF::loadView('pdfs.sheet', compact('data'))->save(storage_path('app/public').'/pdfs/'.$request->group.'.pdf');
            \Cache::store('file')->put($request->group, 1, 120);
        }

        return $pdf->stream();
    }
}
