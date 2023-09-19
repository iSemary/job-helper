<?php

namespace App\Http\Controllers;

use App\Imports\CompaniesImport;
use App\Models\Company;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class CompanyController extends Controller {
    public function index() {
        if (request()->dataTables) {
            $companies = Company::where('user_id', auth()->user()->id)->orderBy('id', "DESC");
            return DataTables::of($companies)->addColumn('action', function ($row) {
                $btn = '';
                $btn .= '<button type="button" data-url="' . route('panel.companies.edit', $row->id) . '" class="btn btn-primary btn-sm open-modal-btn"><i class="far fa-edit"></i></button>';
                $btn .= '<button type="button" data-delete-type="company" data-url="' . route('panel.companies.destroy', $row->id) . '" class="btn btn-danger btn-sm delete-btn"><i class="fa fa-trash"></i></button>';
                $btn .= '<button type="button" data-url="' . route('panel.companies.edit', $row->id) . '" class="btn btn-purple btn-sm open-modal-btn"><i class="fas fa-magic"></i></button>';
                return $btn;
            })->rawColumns(['action'])->make(true);
        }
        return view("panel.companies.index");
    }

    public function show($id) {
        $company = Company::where('id', $id)->where("user_id", auth()->user()->id)->first();
        if ($company) {
            return response()->json(['message' => 'Company fetched successfully', 'company' => $company], 200);
        }
        return response()->json(['message' => 'Company not exists'], 500);
    }

    public function create() {
        return view("panel.companies.editor");
    }

    public function edit($id) {
        $company = Company::where('id', $id)->where("user_id", auth()->user()->id)->first();
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
        return response()->json(['message' => 'Company record created successfully']);
    }

    public function update(Request $request, $id) {
        // Find the company record by its ID and it's user id
        $company = Company::where('id', $id)->where('user_id', auth()->user()->id)->firstOrFail();

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
        return response()->json(['message' => 'Company record updated successfully']);
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
            return response()->json(['message' => 'Company dataset imported successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => "Error Code : " .  $e->getCode()], 500);
        }
    }

    public function destroy($id) {
        $company = Company::where('id', $id)->where("user_id", auth()->user()->id)->delete();
        return response()->json(['message' => 'Company record deleted successfully']);
    }
}
