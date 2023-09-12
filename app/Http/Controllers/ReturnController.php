<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use Illuminate\Http\Request;

class ReturnController extends Controller
{
    public function showReturn(Issue $issue)
    {
        return $issue;
    }
}
