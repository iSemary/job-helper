<?php

namespace App\Observers;

use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CompanyObserver {
    /**
     * Handle the Company "created" event.
     */
    public function created(Company $company): void {
        DB::table('company_log')->insert([
            "company_id" => $company->id,
            "status" => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }

    /**
     * Handle the Company "updated" event.
     */
    public function updated(Company $company): void {
        if ($company->isDirty('status')) {
            DB::table('company_log')->insert([
                "company_id" => $company->id,
                "status" => $company->status['id'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }

    /**
     * Handle the Company "deleted" event.
     */
    public function deleted(Company $company): void {
        //
    }

    /**
     * Handle the Company "restored" event.
     */
    public function restored(Company $company): void {
        //
    }

    /**
     * Handle the Company "force deleted" event.
     */
    public function forceDeleted(Company $company): void {
        //
    }
}
