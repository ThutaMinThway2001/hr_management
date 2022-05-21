<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCompanySetting;
use App\Models\CompanySetting;
use App\Models\User;
use Illuminate\Http\Request;

class CompanySettingController extends Controller
{
    public function show(CompanySetting $company_setting){
        if(!auth()->user()->can('view_company_setting')) {
            abort(403, 'message');
        }
        return view('company-settings.show', compact('company_setting'));
    }

    public function edit(CompanySetting $company_setting){
        if(!auth()->user()->can('edit_company_setting')) {
            abort(403, 'message');
        }
        return view('company-settings.edit', compact('company_setting'));
    }

    public function update(UpdateCompanySetting $request, CompanySetting $company_setting){

        $attributes = $request->validated();
        $company_setting->update($attributes);

        return redirect()->route('company-settings.show', 1)->with('updated', 'Company Setting Updated Successfully');
        
    }
}
