<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    public function list_departments()
    {
        $departments = Department::where('status', 1)->get();
        return response()->json($departments);
    }
}
