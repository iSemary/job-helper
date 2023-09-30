<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailMessage extends Model {
    use HasFactory;
    protected $fillable = ['company_id', 'prompt', 'content', 'type', 'status'];
}
