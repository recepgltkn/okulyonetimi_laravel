<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class StudentPanelController extends Controller
{
    /**
     * Render legacy panel.
     */
    public function show(string $page = 'dashboard'): View
    {
        return view('legacy.home');
    }
}
