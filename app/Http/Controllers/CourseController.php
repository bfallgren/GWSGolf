<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Barryvdh\Debugbar\Facade as DebugBar;
use Auth;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      if(request()->ajax()) {
        return datatables()->of(Course::select('*'))
       
        ->addColumn('action', function ($rows) {
          $button = '<div class="btn-group btn-group-xs">';
          $button .= '<a href="/courses/' . $rows->id . '/edit" title="Edit" ><i class="fa fa-edit fa-fw" style="font-size:15px;margin-right:10px"></i></a>';
          $button .= '<button type="button" title="Delete" name="deleteButton" id="' . $rows->id . '" class="deleteButton" style="font-size:12px;margin-right:10px"><i class="fas fa-trash-alt fa-fw" style="color:red"></i></button>';
          $button .= '<a href="/ratings/' . $rows->id . ' " title="Course Ratings" ><i class="fas fa-hand-point-right fa-fw" style="font-size:15px; color:green"></i></a>';
          $button .= '</div>';
          return $button;
      })
      ->rawColumns(['action'])
      ->make(true);


    }

        return view('courses.index'); 
    }



    Public function fetchCourses(Request $request)
    {
    
     if($request->ajax())
     {
      
      $sort_by = $request->get('sortby');
      $sort_type = $request->get('sorttype');
            $query = $request->get('query');
            $query = str_replace(" ", "%", $query);
            $items = $request->get('items');
      $data = DB::table('courses')
                    ->where('name', 'like', '%'.$query.'%')
                    ->orWhere('state', 'like', '%'.$query.'%')
                    ->orderBy($sort_by, $sort_type)
                    ->paginate($items);
      return view('courses.index_data', compact('data'))->render();
     
     }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('courses.create');
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
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $filename= $request->image->getClientOriginalName();
            $request->image->move(public_path('images/courses'), $filename);
            $newRec = new course();
            $newRec->name = $request->get('name');
            $newRec->city = $request->get('city');
            $newRec->state = $request->get('state');
            $newRec->image = $filename;
            $newRec->save();
            return redirect('courses')->with('success','Golf Course has been added');
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
        $param = request()->route()->parameter('course');
        $request->session()->put('glob',$param);
        $course = course::find($id);
        return view('courses.edit',compact('id','course','param'));
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
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $filename= $request->image->getClientOriginalName();          
            $request->image->move(public_path('images/courses'), $filename);
            $course = course::find($id);
            $param = $request->session()->get('glob');
            $course->name = $request->get('name');
            $course->city = $request->get('city');
            $course->state = $request->get('state');
            $course->image = $filename;
            $course->save();
            return redirect('courses')->with('success','Golf Course has been updated');  

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("courses")->delete($id);
        /* return response()->json(['success'=>"Golf Course Deleted successfully.", 'tr'=>'tr_'.$id]); */
        return redirect('courses')->with('success','Golf Course Has Been Deleted');
    }
}
