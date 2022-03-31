<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Score;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Auth;

class ArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    Public function index(Request $request)
        {
            if(request()->ajax())
                {
                    if(!empty($request->from_date))
                        {
                            $currentuserid = Auth::user()->id;
                            /* join tables */
                            date_default_timezone_set('US/Eastern');
                            date_default_timezone_get();
                    
                            $currentYear = now()->year;
                                
                            $data = DB::table('scores')
                            ->join('courses','courses.id','=', 'scores.course_id')
                            ->select('scores.*','courses.name')
                            ->where('user_id','=',$currentuserid)
                            ->whereBetween('date_played', array($request->from_date, $request->to_date))
                            ->orderBy('date_played', 'desc')
                            ->get();
                        }
                    else
                        {
                            $currentuserid = Auth::user()->id;
                            /* join tables */
                            date_default_timezone_set('US/Eastern');
                            date_default_timezone_get();
                    
                            $currentYear = now()->year;
                                
                            $data = DB::table('scores')
                            ->join('courses','courses.id','=', 'scores.course_id')
                            ->select('scores.*','courses.name')
                            ->where('user_id','=',$currentuserid)
                            ->whereYear('date_played','=',$currentYear)
                            ->orderBy('date_played', 'desc')
                            ->get();
                        }
                        //dd($data);
                        return datatables()->of($data)->make(true);
                }
               
            return view('archives.index');
        }
    
}
