<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Http\Response;

class AdminHomeController extends Controller
{
    /**
     * AdminHomeController constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return Response
     */
    public function index()
    {
        return view('admin.home');
    }
}
