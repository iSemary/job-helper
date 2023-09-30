<?php

namespace App\Models;

use App\Interfaces\CompanyStatusesInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model {
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'phone', 'email', 'industry', 'job_title', 'job_description', 'job_salary', 'hr_name', 'hr_email', 'website', 'status'];
    protected $appends = ['status'];

    public function getStatusAttribute() {
        return CompanyStatusesInterface::getDetails($this->attributes['status']);
    }
    public function cover_letters() {
        return $this->hasMany(CoverLetter::class);
    }
    public function scopeAuth($query) {
        return $query->where("user_id", auth()->user()->id);
    }

}
