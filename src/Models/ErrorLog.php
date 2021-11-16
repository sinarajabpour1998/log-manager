<?php

namespace Sinarajabpour1998\LogManager\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ErrorLog extends Model
{
    use HasFactory;
    protected $fillable = ["user_id", "ip", "os", "browser", "error_message", "error_code", "target_file", "target_line", "seen"];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
