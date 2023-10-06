<?php

namespace App\Http\Controllers;

use App\Imports\CompaniesImport;
use App\Models\Company;
use App\Models\EmailMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class CompanyController extends Controller {
    public function index() {
        if (request()->dataTables) {
            $companies = Company::Auth()->orderBy('id', "DESC");
            return DataTables::of($companies)
                ->addColumn("status", function ($row) {
                    return $row->status['title'];
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="w-100">';
                    $btn .= '<button type="button" data-toggle="tooltip" data-placement="top" title="Edit" data-url="' . route('panel.companies.edit', $row->id) . '" class="btn btn-primary btn-sm open-modal-btn"><i class="far fa-edit"></i></button>';
                    $btn .= '<button type="button" data-toggle="tooltip" data-placement="top" title="Delete" data-delete-type="company" data-url="' . route('panel.companies.destroy', $row->id) . '" class="btn btn-danger btn-sm delete-btn"><i class="fa fa-trash"></i></button>';
                    $btn .= '<button type="button" data-toggle="tooltip" data-placement="top" title="Generate" data-url="' . route('panel.companies.edit', $row->id) . '" class="btn btn-purple btn-sm open-modal-btn"><i class="fas fa-magic"></i></button>';
                    $btn .= '<button type="button" data-toggle="tooltip" data-placement="top" title="Log" data-url="' . route('panel.companies.log', $row->id) . '" class="btn btn-warning btn-sm open-modal-btn"><i class="fas fa-history"></i></button>';
                    $btn .= '</div>';
                    return $btn;
                })->rawColumns(['status', 'action'])->make(true);
        }
        return view("panel.companies.index");
    }

    public function show($id) {
        $company = Company::with(['cover_letters' => function ($query) {
            $query->orderBy('id', 'desc');
        }])->where('id', $id)->Auth()->first();

        if ($company) {
            $company['motivation_message'] = EmailMessage::where("company_id", $company->id)->where("type", 1)->first();
            $company['reminder_message'] = EmailMessage::where("company_id", $company->id)->where("type", 2)->first();
            return response()->json(['message' => 'Company fetched successfully', 'company' => $company], 200);
        }
        return response()->json(['message' => 'Company not exists'], 500);
    }

    public function create() {
        return view("panel.companies.editor");
    }

    public function edit($id) {
        $company = Company::where('id', $id)->Auth()->first();
        return view("panel.companies.editor", compact("company"));
    }

    public function store(Request $request) {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'industry' => 'nullable|string',
            'job_title' => 'nullable|string',
            'job_description' => 'nullable|string',
            'job_salary' => 'nullable|numeric',
            'hr_name' => 'nullable|string',
            'hr_email' => 'nullable|email',
            'website' => 'nullable|url',
        ]);

        // Append current user id to the requested data 
        $validatedData['user_id'] = auth()->user()->id;

        // Create a new Company record
        $company = new Company($validatedData);

        // Save the new company record to the database
        $company->save();
        return response()->json(['message' => 'Company record created successfully', 'status' => 200]);
    }

    public function update(Request $request, $id) {
        // Find the company record by its ID and it's user id
        $company = Company::where('id', $id)->Auth()->firstOrFail();

        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'industry' => 'nullable|string',
            'job_title' => 'nullable|string',
            'job_description' => 'nullable|string',
            'job_salary' => 'nullable|numeric',
            'hr_name' => 'nullable|string',
            'hr_email' => 'nullable|email',
            'website' => 'nullable|url',
        ]);

        // Append current user id to the requested data 
        $validatedData['user_id'] = auth()->user()->id;

        // Update the company record with the validated data
        $company->update($validatedData);
        return response()->json(['message' => 'Company record updated successfully', 'status' => 200]);
    }

    public function importExcel() {
        return view("panel.companies.import");
    }

    public function storeExcel(Request $request) {
        try {
            $request->validate([
                'excel_file' => 'required|file|mimes:xls,xlsx,csv|max:30720', // Max: 30Mb
            ]);
            $companiesSheet = $request->file('excel_file');
            Excel::import(new CompaniesImport(auth()->user()->id), $companiesSheet);
            return response()->json(['message' => 'Company dataset imported successfully', 'status' => 200]);
        } catch (\Exception $e) {
            return response()->json(['message' => "Error Code : " .  $e->getCode()], 500);
        }
    }

    public function destroy($id) {
        $company = Company::where('id', $id)->Auth()->delete();
        return response()->json(['message' => 'Company record deleted successfully', 'status' => 200]);
    }

    public function updateStatus(Request $request) {
        $company = Company::find($request->id);
        $company->status = $request->status;
        $company->save();

        return response()->json(['message' => 'Company status updated successfully', 'status' => 200]);
    }

    public function log($id) {
        $company = Company::where('id', $id)->Auth()->first();
        if ($company) {
            $companyLogs = DB::table('company_log')->where("company_id", $id)->orderBy('id', "DESC")->get();
            return view("panel.companies.log", compact("companyLogs"));
        }
    }
}
