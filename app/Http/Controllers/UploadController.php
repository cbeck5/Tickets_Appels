<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Jobs\ProcessImport;

class UploadController extends Controller
{
    /**
     * Upload CSV file to database
     */
    public function uploadCSVFile(Request $request)
    {
    	$data = []; 

    	if($request->file('file_upload') == null)
    	{
    		Session::flash('error', 'Veuillez choisir un fichier.'); 
            return back()->withInput();
    	}
    	else
    	{
        	$path = $request->file('file_upload')->store('public');
            //Import in database by a job ProcessImport with queue
 	        ProcessImport::dispatch($path)->onQueue('urgent');
        }

    		Session::flash('message', 'Le fichier est en cours de chargement dans la base de données.'); 

    	return back()->withInput();
    }
}