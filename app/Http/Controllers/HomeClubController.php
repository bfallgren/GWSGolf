<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Homeclub;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Auth;

class HomeClubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         /* get the logged on user */
         $currentuserid = Auth::user()->id;
         $userName = Auth::user()->name;
                
         $data = DB::table('homeclubs')
        ->join('courses','courses.id','=', 'homeclubs.course_id')
        ->select('homeclubs.*','courses.name')
        ->where('user_id','=',$currentuserid)
        ->orderBy('id', 'desc')
        /*->first();*/ /* no count() */
        ->get(); /*has count()*/
        
        $scores = $under90 = $avgscore = $lowround = $lowdiff = $cost_of_rounds = 0;

        if (isset($data[0])) {
           
            $homeclub_course_id = $data[0]->course_id; /*Property [course_id] does not exist on this collection instance.*/
            $daily_fee = $data[0]->avg_daily_fee;
    
            $currentYear = now()->year;

            if ($userName == 'admin') {
                    $scores = DB::table('scores')
                    ->select('scores.score')
                    ->where('course_id',$homeclub_course_id)
                    ->whereYear('date_played','=',$currentYear)
                    ->get();
            }
            else {
                $scores = DB::table('scores')
                ->select('scores.score')
                ->where('user_id','=',$currentuserid)
                ->where('course_id',$homeclub_course_id)
                ->whereYear('date_played','=',$currentYear)
                ->get(); 

                $under90 = DB::table('scores')
                ->select('scores.score')
                ->where('user_id','=',$currentuserid)
                ->where('course_id',$homeclub_course_id)
                ->where('score','<', '90')
                ->whereYear('date_played','=',$currentYear)
                ->get();

                $avgscore = DB::table('scores')
                ->select('scores.score')
                ->where('user_id','=',$currentuserid)
                ->where('course_id',$homeclub_course_id)
                ->whereYear('date_played','=',$currentYear)
                ->avg('score');

                $lowround = DB::table('scores')
                ->select('scores.score')
                ->where('user_id','=',$currentuserid)
                ->where('course_id',$homeclub_course_id)
                ->whereYear('date_played','=',$currentYear)
                ->min('score');
                
                $lowdiff = DB::table('scores')
                ->select('scores.score')
                ->where('user_id','=',$currentuserid)
                ->where('course_id',$homeclub_course_id)
                ->whereYear('date_played','=',$currentYear)
                ->min('diff');
            }

            $cost_of_rounds = $daily_fee * $scores->count();
           // dd($data,$scores,$under90,$avgscore,$lowround,$lowdiff,$cost_of_rounds);
            return view('home_clubs.index', compact('data','scores','under90','avgscore','lowround','lowdiff','cost_of_rounds')); 
        }
       // no data ... call create() function
        return $this->create();
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $course = DB::table('courses')
        ->orderby('name','asc')
        ->pluck("name","id");
     
        if ($course->count() == 0) {
            $alertMsg = "You must add a course first";
            return view('home_clubs.create',compact('course'))->with('alertMsg',$alertMsg);
            //return view('home_clubs.create',compact('course'))-> alert()->warning('Sweet Alert with warning.');
        }
        return view('home_clubs.create',compact('course'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'avg_daily_fee' => 'required',
            'annual_membership_fee' => 'required',
            ]);
            /* return course id from course name selected in blade */
            $course_select = $request->get('course');
            $course_db = DB::table('courses')
            ->select('id')
            ->where('name', $course_select)
            ->first();
            $returned_course_id = $course_db->id;
            
            $newRec = new Homeclub();
            $currentuserid = Auth::user()->id;
            $newRec->user_id = $currentuserid;
            $newRec->course_id = $returned_course_id;
            $newRec->avg_daily_fee = $request->get('avg_daily_fee');
            $newRec->annual_membership_fee = $request->get('annual_membership_fee');
            $newRec->shop_credit = $request->get('shop_credit');
            $newRec->image = $request->get('image');
            $newRec->save();
            return redirect('homeclub')->with('success','Home Club profile has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Homeclub::find($id);
        $course = DB::table('courses')
        ->orderby('name','asc')
        ->pluck("name","id");
        return view('home_clubs.edit',compact('id','data','course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'course' => 'required',
            ]);

            $course_select = $request->get('course');
            $course_db = DB::table('courses')
            ->select('id')
            ->where('name', $course_select)
            ->first();
            $returned_course_id = $course_db->id;

            $homeclub = Homeclub::find($id);
            $currentuserid = Auth::user()->id;
            $homeclub->user_id = $currentuserid;
            $homeclub->course_id = $returned_course_id;
            $homeclub->avg_daily_fee = $request->get('avg_daily_fee');
            $homeclub->annual_membership_fee = $request->get('annual_membership_fee');
            $homeclub->shop_credit = $request->get('shop_credit');
            $homeclub->image = $request->get('image');
            $homeclub->save();
            return redirect('homeclub')->with('success','Home Club profile has been updated');  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("homeclubs")->delete($id);
        return redirect('homeclub')->with('success','Home Club profile Has Been Deleted'); //
    }
}
