<?php

namespace App\Http\Controllers;
use App\bus_routes;
use App\bus;
use App\routes;
use Illuminate\Http\Request;

class BusroutesController extends Controller
{
    //Get Function
    public function index()
    {
        $bus_routes = bus_routes::all();
        return response()->json(['bus_routes'=> $bus_routes], 200);
    }

    //Show Function
    public function show($id)
    {
        $bus_routes = bus_routes::find($id);

        if($bus_routes)
        {
            return response()->json(['bus_routes'=> $bus_routes], 200);
        }
        else
        {
            return response()->json(['message'=> 'No Bus Routes Details'], 404);
        }
        
    }

    //Insert Function
    public function store(Request $request)
    {
        $request->validate([
            'bus_id'=>'required',
            'route_id'=>'required',
            'status'=>['required','max:191','regex:(active|blocked)'],
        ]);

        //Get Bus Foreign Key
        $BID=$request->bus_id;
        $bus=bus::find($BID);

        ////Get Route Foreign Key
        $RID=$request->route_id;
        $routes=routes::find($RID);

        $bus_routes = new bus_routes;
        
        if($bus)

        {

            if($routes){  

               $bus_routes->bus_id = $request->bus_id;
               $bus_routes->route_id = $request->route_id;
               $bus_routes->status = $request->status;	
               $bus_routes->save();
               return response()->json(['message'=>' Bus Routes Added Successfully'], 200);
       }

       else{

        return response()->json(['message'=>' Route ID Not Found'], 404);

         }
    }

       else
        {
            return response()->json(['message'=>' Bus ID Not Found'], 404);
        }
       

    }

    //Update Function
    public function update(Request $request, $id)
    {
        $request->validate([
            'bus_id'=>'required',
            'route_id'=>'required',
            'status'=>['required','max:191','regex:(active|blocked)'],
        ]);
  
        $bus_routes = bus_routes::find($id);
        if($bus_routes)
        {
            $bus_routes->bus_id = $request->bus_id;
            $bus_routes->route_id = $request->route_id;
            $bus_routes->status = $request->status;		
            $bus_routes->update();
            return response()->json(['message'=>'Bus Routes Update Successfully'], 200);
        }
        else
        {
            return response()->json(['message'=>'Not Update Bus Routes Details'], 404);
        }
        
    }

    //Delete Function
    public function destroy($id)
    {
        $bus_routes = bus_routes::find($id);
        if($bus_routes)
        {
            $bus_routes->delete();
            return response()->json(['message'=>'Bus Routes Delete Successfully'], 200);
        }
        else
        {
            return response()->json(['message'=>'Not Delete Bus Routes Details'], 404);
        }
    }

}
