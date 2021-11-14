<?php

namespace Sinarajabpour1998\LogManager\Http\Controllers;

use App\Models\User;
use Sinarajabpour1998\LogManager\Facades\LogFacade;
use Sinarajabpour1998\LogManager\Models\Log;

class LogController extends Controller
{
    public function index()
    {
        $logs = LogFacade::getLogsWithFilter($request);
        if (!is_null(request('creator_id'))){
            $user = User::query()->findOrFail(request('user_id'));
        }
        return view('vendor.LogManager.logs.index', [
            'logs' => $logs->logs,
            'show_filter' => $logs->show_filter,
            'user' => $user
        ]);
    }
}
