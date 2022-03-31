<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Club;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Auth;
use Datatables;

class ClubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      if(request()->ajax()) {
        return datatables()->of(Club::select('*'))
       
        ->addColumn('action', function ($rows) {
          $button = '<div class="btn-group btn-group-xs">';
          $button .= '<a href="/clubs/' . $rows->id . '/edit" title="Edit" ><i class="fa fa-edit" style="font-size:15px;margin-right:10px"></i></a>';
          $button .= '<button type="button" title="Delete" name="deleteButton" id="' . $rows->id . '" class="deleteButton" style="font-size:12px"><i class="fas fa-trash-alt" style="color:red"></i></button>';
          $button .= '</div>';
          return $button;
      })
      ->rawColumns(['action'])
      ->make(true);


    }

        return view('clubs.index'); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clubs.create');
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
            'vendor' => 'required',
             ]);
            $newRec = new Club();
            $currentuserid = Auth::user()->id;
            $newRec->user_id = $currentuserid;
            $newRec->name = $request->get('name');
            $newRec->vendor = $request->get('vendor');
            $newRec->loft = $request->get('loft');
            $newRec->lie = $request->get('lie');
            $newRec->length = $request->get('length');
            $newRec->swing_weight = $request->get('swing_weight');
            $newRec->yardage = $request->get('yardage');
            $newRec->save();
            return redirect('clubs')->with('success','Golfclub has been added');
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
        $club = Club::find($id);
        return view('clubs.edit',compact('id','club'));
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
            'vendor' => 'required',
             ]);
            $club = Club::find($id);
            $currentuserid = Auth::user()->id;
            $club->user_id = $currentuserid;
            $club->name = $request->get('name');
            $club->vendor = $request->get('vendor');
            $club->loft = $request->get('loft');
            $club->lie = $request->get('lie');
            $club->length = $request->get('length');
            $club->swing_weight = $request->get('swing_weight');
            $club->yardage = $request->get('yardage');
            $club->save();
            return redirect('clubs')->with('success','Golfclub has been updated');  

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("clubs")->delete($id);
        /* return response()->json(['success'=>"Golfclub Deleted successfully.", 'tr'=>'tr_'.$id]); */
        return redirect('clubs')->with('success','Golfclub Has Been Deleted');
    }
}
