<?php

namespace App\Http\Controllers;

use App\Interfaces\CompanyStatusesInterface;
use App\Models\Company;
use App\Models\CoverLetter;
use App\Models\Email;

class DashboardController extends Controller {
    public function welcome() {
        return view("guest.welcome");
    }
    public function register() {
        return view("guest.register");
    }
    public function home() {
        $companies = Company::Auth()->count();
        $emailsSent = Email::where("user_id", auth()->user()->id)->where("type", 1)->count();
        $coverLetters = CoverLetter::where("user_id", auth()->user()->id)->count();
        $remindersSent = Email::where("user_id", auth()->user()->id)->where("type", 2)->count();
        return view("panel.home", compact('companies', 'emailsSent', 'coverLetters', 'remindersSent',));
    }
    public function kanban() {
        $statuses = CompanyStatusesInterface::returnStatuesAsJson()->getData()->data;
        $companies = Company::select(['id', 'name', 'status'])->where("user_id", auth()->user()->id)->get();

        $kanbanCompanies = $this->prepareKanbanCompanies($companies);

        $kanbanCompanies = json_encode($kanbanCompanies, JSON_UNESCAPED_SLASHES);

        return view("panel.kanban", compact("statuses", 'kanbanCompanies'));
    }

    public function prepareKanbanCompanies(object $companies): array {
        $kanbanCompanies = [];

        foreach ($companies as $key => $company) {
            $kanbanCompanies[] = [
                "id" => $company->id,
                "state" => $company->status['state'],
                "label" => $company->name,
                "name" => $company->name,
                "hex" => $company->status['hex'],
                "resourceId" => $company->id,
                "tags" => "/",
                "image" => "/assets/images/office-building.png",
            ];
        }

        return $kanbanCompanies;
    }
}
