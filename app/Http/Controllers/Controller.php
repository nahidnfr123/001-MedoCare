<?php

namespace App\Http\Controllers;

use App\ContactUs;
use Exception;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\URL;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function decryptID($id){
        try{
            $id = decrypt($id);
            return $id;
        }
        catch (Exception $e) {
            //return $e->getMessage();
            //redirect('404');
            abort(403, 'Unauthorized action.');
        }
    }


}
