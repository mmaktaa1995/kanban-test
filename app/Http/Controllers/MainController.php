<?php

namespace App\Http\Controllers;

use Spatie\DbDumper\Databases\MySql;

class MainController extends Controller
{
    public function exportDB()
    {
        MySql::create()
            ->setDbName(env('DB_DATABASE'))
            ->setUserName(env('DB_USERNAME'))
            ->setPassword(env('DB_PASSWORD'))
            ->dumpToFile('dump.sql');
        return response()->json(['message' => 'Database dum in progress!']);
    }
}
