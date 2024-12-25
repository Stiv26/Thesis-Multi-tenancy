<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RenterController extends Controller
{
    public function header()
    {
        $data = 'Dashboard';
        return view('dashboard', compact('data'));
    }

    public function tenant()
    {
        $data = DB::table('renter as r')
            ->join('domains as d', 'r.domains_id', '=', 'd.id')
            ->select('*', 'r.id as idTenant')
            ->get();

        return view('dashboard', compact('data'));
    }

    public function detailTenant($id)
    {
        $data = DB::table('renter as r')
            ->join('domains as d', 'r.domains_id', '=', 'd.id')
            ->select('*', 'r.id as idTenant')
            ->where('r.id', '=', $id)
            ->first();

        return response()->json($data);
    }
}
