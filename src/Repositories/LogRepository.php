<?php

namespace Sinarajabpour1998\LogManager\Repositories;

use App\Models\User;
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

    protected function findUser($search, $type = null)
    {
        $users = User::query();
        if (!is_null($type) && $type == "admins"){
            $users = $users->whereRoleIs('admin')->orWhereRoleIs('programmer');
        }
        $users->where(function ($query) use ($search){
            $query->whereRaw("concat_ws('',first_name,last_name) like ?", ['%' . $search . '%']);
            $query->orWhere('email_key', '=', [ makeHash($search) ]);
            $query->orWhere('mobile_key', '=', [ makeHash($search) ]);
        });
        return $users->get();
    }
}
