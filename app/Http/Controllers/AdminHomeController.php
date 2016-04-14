<?php

namespace App\Http\Controllers;

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
        return redirect()->route('admin.user.list');
    }
}
