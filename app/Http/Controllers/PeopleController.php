<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\People;
use App\Person;
use Illuminate\Support\Arr;
use Carbon;

class PeopleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $people = People::all();
        $personArray = [];
        foreach($people as $idx=> $recd) {
            $data = json_decode($recd->sorted_payload)->data;
            foreach ($data as $person) {
                $p = new Person((array)$person);
                $p->id = $recd->id;
                $personArray[] = $p;
            }
        }
        return response()->json($personArray);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	    $input = $request->json()->all();
	    $data =$input['data'] ?? null;

	    if ($data) {

		    $emails = array_column($data,'email');
		    $emailString = implode(',', $emails);

		    $sortedData = $this->add_name_field($data);
		    usort($sortedData,function($a, $b) {
			    return $a['age'] < $b['age'];
			});
		    $payload = json_encode(['data'=>$sortedData]);
		    
	    		$people = new People;
	    		$people->email_addresses = json_encode(['data'=>$emailString]);
	    		$people->sorted_payload = $payload;
	    		$people->source_ip_address = $request->ip();
	    		$people->posted_at = Carbon::now();
	    		$people->save();
	    		
			return response()->json($people);
	    } 
	    
		return response()->json(['status' => false],422);    
	    
    }
    
    private function add_name_field(Array $arr) {
	    $newArray = [];
	    
	    foreach ($arr as $person) {
		    $modelPerson = new Person($person);
		    
		    $newArray[] = $modelPerson->toArray();
		}
		
		return $newArray;
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = false;
        $record = People::find($id);
        if ($record) {
           $status =$record->delete();
        } 
        return response()->json(['status'=>$status]);
    }
}
