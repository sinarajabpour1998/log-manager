<?php

namespace Sinarajabpour1998\LogManager\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sinarajabpour1998\LogManager\Facades\LogFacade;

class SMSLogController extends Controller
{
    public function index(Request $request)
    {
        $user = null;
        $sms_logs = LogFacade::getSMSLogsWithFilter($request);
        if (!is_null(request('user_id'))){
            $user = User::query()->findOrFail(request('user_id'));
        }
        return view('vendor.LogManager.smsLogs.index', [
            'sms_logs' => $sms_logs->sms_logs,
            'show_filter' => $sms_logs->show_filter,
            'user' => $user
        ]);
    }

    public function findUser()
    {
        return LogFacade::getUsers(request());
    }
}
