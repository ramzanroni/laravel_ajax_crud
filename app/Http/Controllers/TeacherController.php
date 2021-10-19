<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        return view('teacher.index');
    }
    public function allData()
    {
        $data=Teacher::all();
        return $data;
    }
    public function storeData(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'title'=>'required',
            'institute'=>'required',
        ]);
        $data= new Teacher();
        $data->name=$request->name;
        $data->title=$request->title;
        $data->institute=$request->institute;
        $data->save();
        return response()->json("Insert Successfully done.");

    }
    public function edit_data($id)
    {
        $data=Teacher::find($id);
        return response()->json($data);
    }
    public function add_edit_data(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'title'=>'required',
            'institute'=>'required',
        ]);
        $data=Teacher::find($request->id);
        $data->name=$request->name;
        $data->title=$request->title;
        $data->institute=$request->institute;
        $data->save();
        return response()->json("Update Successfull.");
    }
    public function delete_data($id)
    {
        $data=Teacher::find($id);
        $data->delete();
        return response()->json("delete Successfully");

    }
}
