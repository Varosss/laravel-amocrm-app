<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
// use Illuminate\Support\Facades\DB;
use App\Models\Leads;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function put_leads_in_db() {
        include __DIR__ . '/../../../main/get_leads.php';

        $count = 0;

        foreach ($leads_collection as $element) {
            if (Leads::where('lead_id', $element['id'])->get()->first()) 
                continue;

            $lead = new Leads();

            $lead->lead_id = $element['id'];
            $lead->data = json_encode($element);

            $lead->save();
        }

        return "<p style='color: green'>success</p>";
    }
}
