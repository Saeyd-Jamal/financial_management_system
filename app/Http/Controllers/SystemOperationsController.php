<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SystemOperationsController extends Controller
{
    public function bakcupsData(){
        exec('mysqldump -u [root] -p[root] --no-create-info [financial_management_system] > backup.sql');
        return response()->download('backup.sql');
        // return response()->download('backup.sql');
    }
}
