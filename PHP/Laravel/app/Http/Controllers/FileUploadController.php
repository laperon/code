<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Imports\DataImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Company;
use App\Group;
use App\Imports\DataImportCompany;
use App\Imports\DataImportGroup;

class FileUploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fileUpload()
    {
        return view('fileUpload');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fileUploadGroup(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx'
        ]);

        $fileName = time().'.'.$request->file->extension();

        $path = $request->file->move(public_path('uploads'), $fileName);

        if($path->getPathname()) {
            $this->importGroup($path->getPathname());
        } else {
            dd('error');
            return back()
            ->with('error','Your file can\'t be uploaded');
        }
        return redirect()->route('admin.groups');
    }

    /**
     * Remove company by id
     *
     * @param $id
     * @return mixed
     */
    public function removeCompany($id)
    {
        Company::where('id', $id)->delete();
        return redirect()->route('admin.companies');
    }

    /**
     * Import company
     *
     * @param $filePath
     * @return mixed
     */
    public function importCompany($filePath)
    {
        Excel::import(new DataImportCompany(), $filePath);
        return redirect()->route('admin.companies');
    }

    /**
     * Import Group
     *
     * @param $filePath
     * @return mixed
     */
    public function importGroup($filePath)
    {
        Excel::import(new DataImportGroup(), $filePath);
        return redirect()->route('admin.groups');
    }
}
