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

    /**
     * Show the 'Can I Eat' tool page.
     */
    public function canIEat()
    {
        return view('tools.can-i-eat');
    }

    /**
     * Show the FAQ page.
     */
    public function faq()
    {
        return view('tools.faq');
    }
}
