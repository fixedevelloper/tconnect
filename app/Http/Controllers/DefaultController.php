<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;

class DefaultController extends Controller
{

    public function documentation(Request $request)
    {

        return view('front.documentation', [

        ]);
    }
    public function home(Request $request)
    {

        return view('front.home', [

        ]);
    }
    public function country(Request $request)
    {

        return view('front.country', [

        ]);
    }
    public function cities(Request $request)
    {

        return view('front.city', [

        ]);
    }

    public function geteway(Request $request)
    {

        return view('front.geteway', [

        ]);
    }
    public function operators(Request $request)
    {

        return view('front.operators', [

        ]);
    }
    public function create_sender(Request $request)
    {

        return view('front.create_sender', [

        ]);
    }
    public function create_beneficiary(Request $request)
    {

        return view('front.create_beneficiary', [

        ]);
    }
    public function transfert_bank(Request $request)
    {

        return view('front.transfert_bank', [

        ]);
    }
    public function transfert_mobil(Request $request)
    {

        return view('front.transfert_mobil', [

        ]);
    }

}
