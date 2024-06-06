<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use App\Models\Workspace;
use App\Models\Noc;
use Auth;
use Gate;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
class AggrementController extends Controller
{
    public function workspace(){
        $workspaces = Workspace::orderBy('id', 'desc')->get();
        return view('admin.aggrement.workspace', compact('workspaces'));
    }

    public function noc(){
        $nocs = Noc::orderBy('id', 'desc')->get();
        return view('admin.aggrement.noc', compact('nocs'));
    }
}
