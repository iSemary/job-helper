<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model {
    use HasFactory;

    protected $fillable = ['user_id', 'company_id', 'email_message_id', 'cover_letter_id', 'message_content', 'status', 'type'];
}
