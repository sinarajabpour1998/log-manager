<?php

namespace Sinarajabpour1998\LogManager\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Sinarajabpour1998\LogManager\Models\ErrorLog;
use Sinarajabpour1998\LogManager\Models\Log;

class LogRepository
{
    public function getAllogs()
    {
        return Log::query()
            ->orderByDesc('id')
            ->paginate();
    }

    public function getLogsWithFilter($request)
    {
        $show_filter = 'false';
        $logs = Log::query();
        if ($request->has('type') && $request->type != ''){
            $logs = $logs->where('type', '=', $request->type);
            $show_filter = 'true';
        }
        if ($request->has('user_id') && $request->user_id != 0){
            $logs = $logs->whereHas('user', function ($query) use ($request){
                $query->where('id', '=', $request->user_id);
            });
            $show_filter = 'true';
        }
        $logs = $logs->orderByDesc('id')->paginate();
        return (object) [
            'logs' => $logs,
            'show_filter' => $show_filter
        ];
    }

    public function getErrorLogsWithFilter($request)
    {
        $show_filter = 'false';
        $error_logs = ErrorLog::query()->selectRaw("id,user_id,ip,os,browser,seen");
        if ($request->has('user_id') && $request->user_id != 0){
            $error_logs = $error_logs->whereHas('user', function ($query) use ($request){
                $query->where('id', '=', $request->user_id);
            });
            $show_filter = 'true';
        }
        $error_logs = $error_logs->orderByDesc('id')->paginate();
        return (object) [
            'error_logs' => $error_logs,
            'show_filter' => $show_filter
        ];
    }

    public function getUsers($request, $type = null)
    {
        $users = array();
        if ($request->has('q')){
            if (!is_null($request->q)){
                $users = $this->findUser($request->q, $type);
            }
        }
        $results = [];
        foreach ($users as $user) {
            $temp = new \stdClass();
            $temp->id = $user->id;
            $temp->text = $user->first_name . ' ' . $user->last_name . ' - ' . decryptString($user->mobile);
            $results[] = $temp;
        }
        $output = new \stdClass();
        $output->results = $results;
        return json_encode($output);
    }

    protected function findUser($search)
    {
        $users = User::query();
        $users->where(function ($query) use ($search){
            $query->whereRaw("concat_ws('',first_name,last_name) like ?", ['%' . $search . '%']);
            $query->orWhere('email_key', '=', [ makeHash($search) ]);
            $query->orWhere('mobile_key', '=', [ makeHash($search) ]);
        });
        return $users->get();
    }

    public function generateLog($type, $description = null)
    {
        $valid_types = config('log-manager.log_types');
        if (!array_key_exists($type, $valid_types)){
            return json_encode([
                "status" => 422,
                "message" => "نوع گزارش پیدا نشد."
            ]);
        }
        $user_id = 0;
        if (Auth::check()){
            $user_id = Auth::user()->id;
        }
        $user_agent = request()->userAgent();
        $user_os = $this->getUserOs($user_agent);
        $user_browser = $this->getUserBrowser($user_agent);
        Log::query()->create([
            "user_id" => $user_id,
            "ip" => request()->getClientIp(),
            "os" => $user_os,
            "browser" => $user_browser,
            "type" => $type,
            "description" => $description
        ]);
        return json_encode([
            "status" => 200,
            "message" => "گزارش ایجاد شد."
        ]);
    }

    public function generateErrorLog($exception)
    {
        $user_id = 0;
        if (Auth::check()){
            $user_id = Auth::user()->id;
        }
        $user_agent = request()->userAgent();
        $user_os = $this->getUserOs($user_agent);
        $user_browser = $this->getUserBrowser($user_agent);
        ErrorLog::query()->create([
            "user_id" => $user_id,
            "ip" => request()->getClientIp(),
            "os" => $user_os,
            "browser" => $user_browser,
            "error_message" => encryptString(base64_encode($exception->getMessage())),
            "error_code" => encryptString(base64_encode($exception->getCode())),
            "target_file" => encryptString(base64_encode($exception->getFile())),
            "target_line" => encryptString(base64_encode($exception->getLine())),
            "seen" => 0
        ]);
        return json_encode([
            "status" => 200,
            "message" => "گزارش خطا ایجاد شد."
        ]);
    }

    protected function getUserOs($user_agent)
    {
        $os_platform = "Unknown OS Platform";

        $kown_platforms = array(
            '/windows nt 10/i'      =>  'Windows 10',
            '/windows nt 6.3/i'     =>  'Windows 8.1',
            '/windows nt 6.2/i'     =>  'Windows 8',
            '/windows nt 6.1/i'     =>  'Windows 7',
            '/windows nt 6.0/i'     =>  'Windows Vista',
            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     =>  'Windows XP',
            '/windows xp/i'         =>  'Windows XP',
            '/windows nt 5.0/i'     =>  'Windows 2000',
            '/windows me/i'         =>  'Windows ME',
            '/win98/i'              =>  'Windows 98',
            '/win95/i'              =>  'Windows 95',
            '/win16/i'              =>  'Windows 3.11',
            '/macintosh|mac os x/i' =>  'Mac OS X',
            '/mac_powerpc/i'        =>  'Mac OS 9',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
            '/iphone/i'             =>  'iPhone',
            '/ipod/i'               =>  'iPod',
            '/ipad/i'               =>  'iPad',
            '/android/i'            =>  'Android',
            '/blackberry/i'         =>  'BlackBerry',
            '/webos/i'              =>  'Mobile'
        );

        foreach ($kown_platforms as $regex => $value){
            if (preg_match($regex, $user_agent)){
                $os_platform = $value;
            }
        }

        return $os_platform;
    }

    protected function getUserBrowser($user_agent)
    {
        $browser = "Unknown Browser";

        $known_browsers = array(
            '/msie/i'      => 'Internet Explorer',
            '/firefox/i'   => 'Firefox',
            '/safari/i'    => 'Safari',
            '/chrome/i'    => 'Chrome',
            '/edge/i'      => 'Edge',
            '/opera/i'     => 'Opera',
            '/netscape/i'  => 'Netscape',
            '/maxthon/i'   => 'Maxthon',
            '/konqueror/i' => 'Konqueror',
            '/mobile/i'    => 'Handheld Browser'
        );

        foreach ($known_browsers as $regex => $value){
            if (preg_match($regex, $user_agent)){
                $browser = $value;
            }
        }

        return $browser;
    }

    public function getErrorLogCount()
    {
        return ErrorLog::query()->where('seen', '=', 0)->count();
    }
}
