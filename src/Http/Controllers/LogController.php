<?php

namespace Sinarajabpour1998\LogManager\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sinarajabpour1998\LogManager\Facades\LogFacade;
use Sinarajabpour1998\LogManager\Models\ErrorLog;
use Sinarajabpour1998\LogManager\Models\Log;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $user = null;
        $logs = LogFacade::getLogsWithFilter($request);
        if (!is_null(request('user_id'))){
            $user = User::query()->findOrFail(request('user_id'));
        }
        return view('vendor.LogManager.logs.index', [
            'logs' => $logs->logs,
            'show_filter' => $logs->show_filter,
            'user' => $user,
            'log_types' => config('log-manager.log_types')
        ]);
    }

    public function errorLogIndex(Request $request)
    {
        $user = null;
        $error_logs = LogFacade::getErrorLogsWithFilter($request);
        if (!is_null(request('user_id'))){
            $user = User::query()->findOrFail(request('user_id'));
        }
        return view('vendor.LogManager.errorLogs.index', [
            'error_logs' => $error_logs->error_logs,
            'show_filter' => $error_logs->show_filter,
            'user' => $user
        ]);
    }

    public function showErrorLog(ErrorLog $log)
    {
        $errorLog = $log;
        if ($errorLog->seen == 0){
            $errorLog->update([
                'seen' => 1
            ]);
        }
        $errorLog->error_message = base64_decode(decryptString($errorLog->error_message));
        $errorLog->error_code = base64_decode(decryptString($errorLog->error_code));
        $errorLog->target_file = base64_decode(decryptString($errorLog->target_file));
        $errorLog->target_line = base64_decode(decryptString($errorLog->target_line));
        return view('vendor.LogManager.errorLogs.show', [
            'errorLog' => $errorLog
        ]);
    }

    public function destroyErrorLog(ErrorLog $log)
    {
        $log->delete();
        return json_encode([
            'status' => 200
        ]);
    }

    public function findUser()
    {
        return LogFacade::getUsers(request());
    }
}
