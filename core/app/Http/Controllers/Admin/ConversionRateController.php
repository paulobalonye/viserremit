<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Lib\ConversionRate;
use Illuminate\Http\Request;

class ConversionRateController extends Controller
{
    public function index()
    {
        $pageTitle = 'Conversion rate API';
        $providers = ConversionRate::providers();
        return view('admin.country.conversion_rate_api.index', compact('pageTitle', 'providers'));
    }
    public function save(Request $request)
    {
        $gs           = gs();
        $providers    = ConversionRate::providers();
        $providerList = implode(',', array_keys($providers ?? []));
        $request->validate([
            "status"               => "nullable|in:on",
            "provider"             => "required_if:status,on|in:" . $providerList,
            "fixed_adjustment"     => "required_if:status,on|nullable|numeric",
            "percent_adjustment"   => "required_if:status,on|nullable|numeric|gt:-100|lt:100",
            "auto_synchronization" => "nullable|in:on",
        ]);

        $setting      = null;
        if ($request->status == 'on') {
            $setting["status"]               = $request->status;
            $currentProvider                 = $request->provider;
            $setting["provider"]             = $currentProvider;
            $setting[$currentProvider]       = $request->{$currentProvider};
            $setting["fixed_adjustment"]     = $request->fixed_adjustment;
            $setting["percent_adjustment"]   = $request->percent_adjustment;
            $setting["auto_synchronization"] = $request->auto_synchronization == 'on';
        }
        $gs->conversion_rate_api = $setting;
        $gs->save();

        $notify[] = ['success', 'Conversion api settings updated successfully'];
        return back()->withNotify($notify);
    }
}
