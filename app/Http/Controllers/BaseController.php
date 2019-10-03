<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class BaseController extends Controller
{
    public function frequentlyAskedQuestions()
    {
        return view('faq');
    }

    public function legalMentions()
    {
        return view('legal-mentions');
    }

    public function contact()
    {
        return view('contact-us');
    }
}
