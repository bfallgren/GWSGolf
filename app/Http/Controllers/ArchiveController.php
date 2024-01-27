<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Score;
use App\User;
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
                            if(!empty($request->golfer))
                            {
                                $users = DB::table('users')->where('name', $request->golfer);
                                $user_id = $users->pluck('id');
                                \Debugbar::info('#2',$user_id);
                            }
                            else {
                                $user_id = Auth::user()->id;
                            }
                            
                            /* join tables */
                            date_default_timezone_set('US/Eastern');
                            date_default_timezone_get();
                    
                            $currentYear = now()->year;
                            \Debugbar::info('#3',$user_id);
                            $data = DB::table('scores')
                            ->join('courses','courses.id','=', 'scores.course_id')
                            ->select('scores.*','courses.name')
                            ->where('user_id','=',$user_id)
                            ->whereBetween('date_played', array($request->from_date, $request->to_date))
                            ->orderBy('date_played', 'desc')
                            ->get();
                        }
                    else
                        {
                            $user_id = Auth::user()->id;
                            /* join tables */
                            date_default_timezone_set('US/Eastern');
                            date_default_timezone_get();
                    
                            $currentYear = now()->year;
                                
                            $data = DB::table('scores')
                            ->join('courses','courses.id','=', 'scores.course_id')
                            ->select('scores.*','courses.name')
                            ->where('user_id','=',$user_id)
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
