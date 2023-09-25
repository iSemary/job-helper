<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoverLetter extends Model {
    use HasFactory;
    protected $fillable = ['user_id', 'company_id', 'prompt', 'content', 'original_file_name', 'file_name', 'status'];
}
