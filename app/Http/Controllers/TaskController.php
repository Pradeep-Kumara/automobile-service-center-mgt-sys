<?php
namespace App\Http\Controllers;


//use App\Task;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TaskController extends Controller
{

    public function taskIndex(){

        $taskView=Task::all();
        return view('task',['title'=>'Task','taskView'=>$taskView]);
        

    }

    public function save(Request $request)
    {
        
        $taskName=$request['taskName'];
        $taskDesc=$request['taskDesc'];
        $taskDuration=$request['taskDuration'];
        $taskCost=$request['taskCost'];
        $taskPrice=$request ['taskPrice'];
        
        
        $validator = \Validator::make($request->all(), [

            
            'taskName' => 'required',
            'taskDesc' => 'required|max:45',
            'taskDuration'=> 'required|not_in:0|numeric',
            'taskCost' => 'required|not_in:0|numeric',
            'taskPrice' => 'required|not_in:0|numeric',
           
        ], [
            
            'taskName.required' => 'Task Name should be provided',
            'taskDesc.required'     => 'Task Description should be provided and must be less than 45 characters long',
            'taskDuration.required'  => 'Duration is mandatory',
            'taskDuration.numeric' => 'Duration should be a number (number of hours)',
            'taskCost.required'      => 'Task cost cannot be blank or zero',
            'taskCost.numeric'      => 'Task cost should be a number',
            'taskPrice.required' => 'Task price cannot be blank or zero',
            'taskPrice.numeric' => 'Task price should be a number',
           
        ]);

        if (Task::where('task_short_description', $taskName)->first()) {
            return response()->json(['errors' => ['error' => 'Task already exist']]);
        }


        if ($validator->fails()) {
            return response()->json(['errors' =>$validator->errors()]);

        }

        $saveTask = new Task();
        $saveTask->task_short_description = $taskName;
        $saveTask->task_long_description = $taskDesc;
        $saveTask->task_estimated_duration= $taskDuration;
        $saveTask->task_cost = $taskCost;
        $saveTask->task_price = $taskPrice;      
        $saveTask->task_status = '1';
        $saveTask->save();

        
        return response()->json(['success' => 'Task saved successfully.']);
    }

    public function getByTaskId(Request $request){

        $taskId=$request['taskId'];
        $task=Task::find($taskId);

        return \response()->json($task);
    }

    public function update(Request $request){

        $updateTaskName=$request['updateTaskName'];
        $updateTaskDesc=$request['updateTaskDesc'];
        $updateTaskDuration=$request['updateTaskDuration'];
        $updateTaskCost=$request['updateTaskCost'];
        $updateTaskPrice=$request['updateTaskPrice'];
        $hiddenTaskId=$request['hiddenTaskId'];
        
        $validator = \Validator::make($request->all(), [

            'updateTaskName' => 'required',
            'updateTaskDesc' => 'required|max:45',
            'updateTaskDuration' => 'required|not_in:0|numeric',
            'updateTaskCost' => 'required|not_in:0|numeric',
            'updateTaskPrice' => 'required|not_in:0|numeric',
            
        ], [
            
            'updateTaskName.required' => 'Task Name should be provided',
            'updateTaskDesc.required'     => 'Task Description should be provided and must be less than 45 characters long',
            'updateTaskDuration.required'  => 'Duration is mandatory',
            'updateTaskDuration.numeric' => 'Duration should be a number (number of hours)',
            'updateTaskCost.required'      => 'Task cost cannot be blank or zero',
            'updateTaskCost.numeric'      => 'Task cost should be a number',
            'updateTaskPrice.required' => 'Task price cannot be blank or zero',
            'updateTaskPrice.numeric' => 'Task price should be a number',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' =>$validator->errors()]);
        
        }
                
        $update=Task::find($hiddenTaskId);
        $update->task_short_description=$updateTaskName;
        $update->task_long_description=$updateTaskDesc;
        $update->task_estimated_duration=$updateTaskDuration;
        $update->task_cost=$updateTaskCost;
        $update->task_price=$updateTaskPrice;
        
        $update->update();

        return \response()->json(['success'=>'Task updated successfully']);
    }

    public function view(Request $request){
        $taskId=$request['taskId'];
        $getTaskDetail=Task::find($taskId);
            return response()->json(['getTaskDetail'=>$getTaskDetail]);
    }


    // public function updateItem(Request $request){
    //     $ItemId=$request['ItemId'];
    //     $getItemDetail=Item::find($ItemId);
    //     $getUomDetail=UOM::find($getItemDetail->item_uom_id);
    //     $getCategoryDetail=Category::find($getItemDetail->item_category_id);

    //         return response()->json(['getItemDetail'=>$getItemDetail, 'getUomDetail'=>$getUomDetail, 'getCategoryDetail'=>$getCategoryDetail]);
    // }

    public function delete(Request $request){
        $taskID=$request['taskID'];
        $delete = Task::find($taskID);
        if($delete!=null){
            $delete->delete();
            
            return response()->json(['success' => 'Deleted successfully.']);
        }
    }
}