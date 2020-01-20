<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Log extends Model
{
    use SoftDeletes;
    public $table = 'laravel_logger_activity';
    public function user()
    {
        return $this->belongsTo(User::class,'userId');
    }
}
