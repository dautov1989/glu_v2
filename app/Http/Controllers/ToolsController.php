<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ToolsController extends Controller
{
    /**
     * Show the Insulin Calculator page.
     */
    public function insulinCalculator()
    {
        return view('tools.insulin-calculator');
    }
}
