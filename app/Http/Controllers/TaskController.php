<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task as Tasks;

class TaskController extends Controller
{
    public function taskView()
    {
    	$tasks = Tasks::where('id','>', 0)->orderBy('priority')->get();

    	return view('tasks',compact('tasks'));
    }

    public function createTask(Request $request){
        // validate
        $validator = \Validator::make($request->all(), [
            'name' => 'required|max:100',
        ]);

        // if error
        if ($validator->fails()) {
            return 'Enter Task Name.';
        }

        // now create new todo
        $todo = new Tasks();

        if (isset($request['name'])) {
            $todo->name = $request['name'];
            $todo->priority = 0;
        }
        // now save
        $todo->save();

        // redirect to home
        return redirect('/');

    }

    public function updateTask(Request $request)
    {
    	$input = $request->all();
        Tasks::where('id',$input['pk'])->update(['name'=>$input['value']]);
    	// foreach ($input['name'] as $key => $value) {
    	// }

    	return response()->json(['status'=>'success']);
    }

    public function deleteTask(Request $request){
        $input = $request->all();
        Tasks::where('id',$input['id'])->delete();
        return response()->json(['status'=>'success']);
    }

    public function sortTask(Request $request)
    {
    	$input = $request->all();

    	foreach ($input['panddingArr'] as $key => $value) {
    		$key = $key+1;
    		Tasks::where('id',$value)->update(['priority'=>$key]);
    	}

    	return response()->json(['status'=>'success']);
    }
}
