<?php

namespace App\Http\Controllers;

use App\Interfaces\CompanyStatusesInterface;
use App\Models\Company;
use App\Models\CoverLetter;
use App\Models\Email;
use Illuminate\View\View;

class DashboardController extends Controller {
    public function welcome() {
        return view("guest.welcome");
    }
    public function register() {
        return view("guest.register");
    }
    /**
     * The function retrieves counts of various data related to the authenticated user and passes them to
     * the "panel.home" view.
     * 
     * @return View a view called "panel.home" and passing the variables , ,
     * , and  to the view.
     */
    public function home(): View {
        $companies = Company::Auth()->count();
        $emailsSent = Email::where("user_id", auth()->user()->id)->where("type", 1)->count();
        $coverLetters = CoverLetter::where("user_id", auth()->user()->id)->count();
        $remindersSent = Email::where("user_id", auth()->user()->id)->where("type", 2)->count();
        return view("panel.home", compact('companies', 'emailsSent', 'coverLetters', 'remindersSent',));
    }
    /**
     * The function "kanban" retrieves company statuses and companies associated with the authenticated
     * user, prepares the data for a kanban board, and returns a view with the statuses and kanban
     * companies.
     * 
     * @return View a view called "panel.kanban" with the variables "statuses" and "kanbanCompanies"
     * compacted.
     */
    public function kanban(): View {
        $statuses = CompanyStatusesInterface::returnStatuesAsJson()->getData()->data;
        $companies = Company::select(['id', 'name', 'status'])->where("user_id", auth()->user()->id)->get();

        $kanbanCompanies = $this->prepareKanbanCompanies($companies);

        $kanbanCompanies = json_encode($kanbanCompanies, JSON_UNESCAPED_SLASHES);

        return view("panel.kanban", compact("statuses", 'kanbanCompanies'));
    }
    /**
     * The function prepares an array of kanban companies by extracting specific properties from an input
     * object.
     * 
     * @param object companies An object containing information about multiple companies. Each company
     * object should have the following properties:
     * 
     * @return array an array of kanban companies. Each kanban company is represented as an associative
     * array with the following keys: "id", "state", "label", "name", "hex", "resourceId", "tags", and
     * "image".
     */
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
