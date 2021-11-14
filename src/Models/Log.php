<?php

namespace Sinarajabpour1998\LogManager\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Log extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ["user_id", "ip", "type", "description"];
    protected $appends = ["type_label"];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getTypeLabelAttribute()
    {
        switch ($this->type) {
            case 'login':
                return 'ورود';
            case 'registration':
                return 'ثبت نام';
            case 'default':
                return 'نامشخص';
        }
    }
}
