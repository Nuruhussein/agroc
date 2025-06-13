<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class PageController extends Controller
{
    public function pricing()
    {
        return Inertia::render('Pricing');
    }

    public function insights()
    {
        return Inertia::render('Insights');
    }
}