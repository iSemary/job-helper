<?php

namespace App\Imports;

use App\Models\Company;
use Maatwebsite\Excel\Concerns\ToModel;

class CompaniesImport implements ToModel {
    protected $userId;
    public function  __construct($userId) {
        $this->userId = $userId;
    }
    public function model(array $rows) {
        return new Company([
            'user_id' => $this->userId,
            'name'  => $rows[0],
            'phone' => $rows[1],
            'email' => $rows[2],
            'industry' => $rows[3],
            'job_title' => $rows[4],
            'job_description' => $rows[4],
            'job_salary' => $rows[7],
            'hr_name' => $rows[5],
            'hr_email' => $rows[6],
            'website' => $rows[8],
        ]);
    }
}
