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
class ScoreController extends Controller
{
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
          function mimic_array_sum($array) {
            $total = 0;
            foreach($array as $number) {
                
                $total = $total + array_shift($number); 
            }
            return $total;
        }


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
      
       $scores = $under90 = $avgscore = $lowround = $lowdiff = $index = "";
       
       if (isset($data[0])) {
       
            $scores = DB::table('scores')
            ->select('scores.score')
            ->where('user_id','=',$currentuserid)
            ->whereYear('date_played','=',$currentYear)
            ->get();

            $under90 = DB::table('scores')
            ->select('scores.score')
            ->where('user_id','=',$currentuserid)
            ->where('score','<', '90')
            ->whereYear('date_played','=',$currentYear)
            ->get();

            $avgscore = DB::table('scores')
            ->select('scores.score')
            ->where('user_id','=',$currentuserid)
            ->whereYear('date_played','=',$currentYear)
            ->avg('score');

            $lowround = DB::table('scores')
            ->select('scores.score')
            ->where('user_id','=',$currentuserid)
            ->whereYear('date_played','=',$currentYear)
            ->min('score');
            
            $lowdiff = DB::table('scores')
            ->select('scores.score')
            ->where('user_id','=',$currentuserid)
            ->whereYear('date_played','=',$currentYear)
            ->min('diff');

            $index = DB::table('scores')
            ->select('scores.diff')
            ->where('user_id','=',$currentuserid)
            ->orderby ('date_played','desc')
            ->limit('20')
            ->get()
            ->toArray()
            ;
            sort($index);

            $outdex = array_slice($index, 0, 8);   
            $val = array_values($outdex);   
            $outdex= json_decode( json_encode($outdex), true); 
            $sum = mimic_array_sum($outdex);  
            $avg = $sum / 8; 

            //dd($outdex,$sum, $avg);

            if(request()->ajax()) {
                return datatables()->of($data)
            
                ->addColumn('action', function ($rows) {
                $button = '<div class="btn-group btn-group-xs">';
                $button .= '<a href="/scores/' . $rows->id . '/edit" title="Edit" ><i class="fa fa-edit" style="font-size:15px;margin-right:10px"></i></a>';
                $button .= '<button type="button" title="Delete" name="deleteButton" id="' . $rows->id . '" class="deleteButton" style="font-size:12px"><i class="fas fa-trash-alt" style="color:red"></i></button>';
                $button .= '</div>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
        
            
                }
            
            return view('scores.index', compact('scores','under90','avgscore','lowround','lowdiff','avg')); 
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
            return view('scores.create',compact('course'))->with('alertMsg',$alertMsg);
            //return view('home_clubs.create',compact('course'))-> alert()->warning('Sweet Alert with warning.');
        }
        return view('scores.create',compact('course'));

        /* get tee after course is selected using jquery */
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
            'score' => 'required',
            ]);
            /* return course id from course name selected in blade */
            $course_select = $request->get('course');
            $course_db = DB::table('courses')
            ->select('id')
            ->where('name', $course_select)
            ->first();
            $returned_course_id = $course_db->id;
            /* return slope and rating from course id to calculate diff */
            $input_tee = $request->get('tee');
            $input_score = $request->get('score');
            $course_rating_db = DB::table('ratings')
            ->select('slope','rating')
            ->where('course_id',  $returned_course_id )
            ->where('tee', $input_tee)
            ->first();
           
            $diff_calc = ((($input_score - $course_rating_db->rating) * 113) / $course_rating_db->slope); 
            $newRec = new Score();
            $currentuserid = Auth::user()->id;
            $newRec->user_id = $currentuserid;
            $newRec->course_id = $returned_course_id;
            $newRec->date_played = $request->get('date_played');
            $newRec->score = $request->get('score');
            $newRec->tee = $request->get('tee');
            $newRec->holes = $request->get('holes');
            $newRec->diff = $diff_calc;
            $newRec->save();
            return redirect('scores')->with('success','Score has been added');
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
        $score = score::find($id);
        $course = DB::table('courses')
        ->orderby('name','asc')
        ->pluck("name","id");
        
        $score_at_course = DB::table('scores')
            ->join('courses','courses.id','=', 'scores.course_id')
            ->select('courses.name','courses.id')
            ->where('scores.id',$id)
            ->first();
                 
        return view('scores.edit',compact('id','score','course','score_at_course'));
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
            'score' => 'required',
            ]);
            /* return course id from course name selected in blade */
            $score = score::find($id);
            $course_select = $request->get('course');
            $course_db = DB::table('courses')
            ->select('id')
            ->where('name', $course_select)
            ->first();
            $returned_course_id = $course_db->id;
            /* return slope and rating from course id to calculate diff */
            $input_tee = $request->get('tee');
            $input_score = $request->get('score');
            $course_rating_db = DB::table('ratings')
            ->select('slope','rating')
            ->where('course_id',  $returned_course_id )
            ->where('tee', $input_tee)
            ->first();
            $diff_calc = ((($input_score - $course_rating_db->rating) * 113) / $course_rating_db->slope); 
            $newRec = new Score();
            $currentuserid = Auth::user()->id;
            $score->user_id = $currentuserid;
            $score->course_id = $returned_course_id;
            $score->date_played = $request->get('date_played');
            $score->score = $request->get('score');
            $score->tee = $request->get('tee');
            $score->holes = $request->get('holes');
            $score->diff = $diff_calc;
            $score->save();
            return redirect('scores')->with('success','Score has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("scores")->delete($id);
        /* return response()->json(['success'=>"Golf Course Deleted successfully.", 'tr'=>'tr_'.$id]); */
        return redirect('scores')->with('success','Score Has Been Deleted'); //
    }

    public function getCourseID($courseName)
    {
        $courseID = DB::table("courses")->where("name",$courseName)->pluck("id");
        
        return(json_encode($courseID));
    }
    
    public function getTee($courseID)
    {
        $course_tee = DB::table("ratings")->where("course_id",$courseID)->pluck("tee","tee")->unique();
        return(json_encode($course_tee));
    }
}
