<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model {
    use HasFactory;
    public $table = 'user_info';

    protected $guarded = [];
    protected $appends = ['resume'];

    public function getResumeAttribute() {
        return isset($this->attributes['resume']) ? asset("storage/user/resume/" . $this->attributes['resume']) : null;
    }
}
