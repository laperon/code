<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Input;
use App\Imports\CompaniesImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Company;
use App\Group;

class AdminController extends Controller
{
    /**
     * Index of Companies
     *
     * @return mixed
     */
    public function indexCompanies()
    {
        $companies = Company::all();
        return view('admin.companies', ['companies' => $companies]);
    }

    /**
     * Index of Groups
     *
     * @return mixed
     */
    public function indexGroups()
    {
        $groups = Group::all();
        return view('admin.groups', ['groups' => $groups]);
    }

    /**
     * Main page
     *
     * @return mixed
     */
    public function index()
    {
        return view('admin.index');
    }
}
