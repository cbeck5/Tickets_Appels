<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use DateTime;

class HomeController extends Controller
{
    /**
     * Show the index on home.
     */
    public function index()
    {
        $nbValue = \App\Models\Consumption::count();
        
        $issetJob = \App\Models\Consumption::count();
        if($nbValue != 0)
        {   
            //TOP 10 DATA
            $topData = \App\Models\Consumption::select('abonne_id', DB::raw('SUM(duration_invoiced_consumption) as topData'))
                                            ->where('type_consumption', 'like', '%connexion%')
                                            ->where('time_consumption', '<', '08:00:00')
                                            ->orwhere('time_consumption', '>', '18:00:00')
                                            ->groupBy('abonne_id')
                                            ->orderBy('topData', 'DESC')
                                            ->take(10)
                                            ->get();
            //SUM CONSUMPTION 
            $sumComm = \App\Models\Consumption::select(DB::raw('SUM(TIME_TO_SEC(duration_real_consumption)) as sumComm'))
                                                ->where('date_consumption', '>=', '2012-02-15')
                                                ->where(function($query) 
                                                {
                                                    $query->orwhere('type_consumption', 'like', 'appel de%')
                                                        ->orwhere('type_consumption', 'like', 'appel émis%')
                                                        ->orwhere('type_consumption', 'like', 'appel vers%')
                                                        ->orwhere('type_consumption', 'like', 'appel vocal international%')
                                                        ->orwhere('type_consumption', 'like', 'appels internes%')
                                                        ->orwhere('type_consumption', 'like', 'consultation messagerie vocale%')
                                                        ->orwhere('type_consumption', 'like', "numéro d'appel spécial%")
                                                        ->orwhere('type_consumption', 'like', 'rappel de votre correspondant%')
                                                        ->orwhere('type_consumption', 'like', "suivi conso #123#%")
                                                        ->orwhere('type_consumption', 'like', "Temps d'attente Appel MVNO%");
                                                })->first();

            $dt1 = new DateTime("@0");
            $dt2 = new DateTime("@$sumComm->sumComm");
            $dayHourSecond = $dt1->diff($dt2)->format('%a jours, %h heures, %i minutes et %s secondes');


            //SUM SMS SEND
            $sumSMS = \App\Models\Consumption::where('type_consumption', 'like', '%envoi de sms%')
                                            ->orwhere('type_consumption', 'like', '%envoi vers des services sms%')
                                            ->count();
        }
        else
        {
            $sumSMS = "";
            $sumComm = "";
            $topData = "";
            $dayHourSecond = "";
        }

        return view('home', compact('nbValue', 'sumSMS', 'sumComm', 'topData', 'dayHourSecond'));
    }
}