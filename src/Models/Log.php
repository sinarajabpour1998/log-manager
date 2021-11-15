<?php

namespace Sinarajabpour1998\LogManager\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Log extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ["user_id", "ip", "os", "browser", "type", "description"];
    protected $appends = ["type_label"];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getTypeLabelAttribute()
    {
        $valid_types = config('log-manager.log_types');
        if (array_key_exists($this->type, $valid_types)){
            return $valid_types[$this->type];
        }else{
            return null;
        }
    }
}
