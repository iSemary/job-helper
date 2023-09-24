<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model {
    use HasFactory;
    public $table = 'user_info';

    protected $guarded = [];
    protected $appends = ['resume', 'open_ai_token'];

    public function getResumeAttribute() {
        return isset($this->attributes['resume']) ? asset("storage/user/resume/" . $this->attributes['resume']) : null;
    }
    public function getOpenAiTokenAttribute() {
        return $this->attributes['open_ai_token'] ? decrypt($this->attributes['open_ai_token']) : "";
    }
}
