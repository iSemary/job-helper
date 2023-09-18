<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailCredentials extends Model {
    use HasFactory;
    protected $fillable = ['user_id', 'mailer', 'host', 'port', 'username', 'password', 'encryption', 'from_address', 'from_name'];
    protected $appends = ['password'];
    public function getPasswordAttribute() {
        return $this->attributes['password'] ? decrypt($this->attributes['password']) : "";
    }
}
