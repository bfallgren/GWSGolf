<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rating;
use App\Course;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Auth;

class CourseRatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$id)
    {
        // save global course id
        $param = request()->route()->parameter('rating');
       
        $request->session()->put('glob',$param);
        /* get the items per page from the view */
        $items = $request->items ?? 10;      
        /* get the records for this user */
        $rating = DB::table('ratings')
        ->where ('course_id','=', $id)
        ->orderBy('id', 'asc')
        ->paginate($items);
       
        $course = DB::table('courses')
        ->where('id','=',$id)
        ->first();
          
        return view('course_ratings.index', compact('rating','items','course')); 
        /*return $rating; */
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $param = $request->session()->get('glob');
       
        $course = DB::table('courses')
        ->where('id','=',$param)
        ->first();
        return view('course_ratings.create',compact('param','course'));
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
            'tee' => 'required',
            'slope' => 'required',
            'rating' => 'required',
            ]);
            $newRec = new Rating();
            $param = $request->session()->get('glob');
            $newRec->course_id = $param;
            $newRec->tee = $request->get('tee');
            $newRec->slope = $request->get('slope');
            $newRec->rating = $request->get('rating');
            $newRec->yardage = $request->get('yardage');
            $newRec->save();
           
            return redirect()->action('CourseRatingController@index',['rating'=>$param])->with('success','Course Rating Has Been Added');
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
    public function edit(Request $request,$id)
    {   
        $param = $request->session()->get('glob');
        $rating = rating::find($id);
        $course = DB::table('courses')
        ->where('id','=',$param)
        ->first();
        return view('course_ratings.edit',compact('id','rating','param','course'));
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
            'tee' => 'required',
            'slope' => 'required',
            'rating' => 'required',
            ]);
            $rating = rating::find($id);
            $param = $request->session()->get('glob');
            $rating->course_id = $param;
            $rating->tee = $request->get('tee');
            $rating->slope = $request->get('slope');
            $rating->rating = $request->get('rating');
            $rating->yardage = $request->get('yardage');
            $rating->save();
            return redirect()->action('CourseRatingController@index',['param'=>$param])->with('success','Course Rating Has Been Updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("ratings")->delete($id);
        /* return response()->json(['success'=>"Golf Course Deleted successfully.", 'tr'=>'tr_'.$id]); */
        return redirect()->back()->with('success','Course Rating Has Been Deleted');
    }
}
