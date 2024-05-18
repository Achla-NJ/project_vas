<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use App\Models\Workspace;
use Auth;
use Gate;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
class AggrementController extends Controller
{
    public function workspace(){
        $workspaces = Workspace::all();
        return view('admin.aggrement.workspace', compact('workspaces'));
    }
}
