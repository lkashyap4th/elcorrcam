<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Auth;
use App\Set;
use App\Camera;

class SetsController extends Controller
{
	/**
	 * Show list of all sets
	 */
	public function getIndex(Request $request)
	{
		$query = Set::orderBy('id','desc');

		$query->where(function($query) use($request)
			{
				$query->orWhere('name','like','%'.$request->global_search.'%');
			});

		$sets = $query->paginate(25);

		return view('pages.sets-list')
		     ->with('sets', $sets)
		     ->with('title', 'Sets List');
	}

	/**
	 * Show create set form
	 * @return view
	 */
	public function getCreate()
	{
		return view('pages.sets-create');
	}

	/**
	 * Handle saving of set data
	 * @param  Request $request
	 * @return redirect
	 */
	public function postCreate(Request $request)
	{
		$this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $set = new Set;
        $set->name = $request->name;
        $set->active = $request->get('active','0');
        $set->save();
        return redirect('/sets');
	}

	/**
	 * Show view set page
	 * @param  int $set_id
	 * @return view
	 */
	public function getView($set_id)
	{
		$set = set::findOrFail($set_id);
		$qrstring = $set->id .','. $set->name.','.count( $set->cameras ); 

		foreach($set->cameras as $camera) {
			$qrstring.= ','.$camera->name.','.$camera->ip_address;
		}

		return view('pages.sets-view')
		     ->with('set', $set)
		     ->with('title', 'View Set')
		     ->with('qrstring' ,$qrstring);

	}

	/**
	 * Show edit set page
	 * @param  int $set_id
	 * @return view
	 */
	public function getEdit($set_id)
	{
		$set = set::findOrFail($set_id);

		return view('pages.sets-edit')
		     ->with('set', $set)
		     ->with('title', 'Edit set');
	}

	/**
	 * Handle edit set data
	 * @param  Request $request
	 * @param  int  $set_id
	 * @return redirect
	 */
	public function postEdit(Request $request, $set_id)
	{
		$this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $set = set::find($set_id);
        $set->name = $request->name;
        $set->active = $request->get('active','0');
        
        $set->save();
        return redirect('/sets');
	}

	/**
	 * Delete set
	 * @param  Request $request
	 * @param  int $set_id
	 * @return redirect
	 */
	public function getDelete(Request $request, $set_id)
	{

		set::where('id', $set_id)->delete();

		if($request->ajax()){
			return ['status'=>'success'];
		}
		return redirect('/sets');
	}

	public function postAddCamera(Request $request)
	{
		$this->validate($request, [
			'name' => 'required',
			'ip_address' => 'required|ip',
		]);

		$set = Set::findOrFail($request->set_id);

		$Camera = new Camera;
		$Camera->name	= $request->name;
		$Camera->ip_address	= $request->ip_address;
		$Camera->active	= $request->get('active','0');
		$Camera->set_id	= $request->set_id;

		$Camera->save();

		return redirect('/sets/view/'.$set->id);
	}

	public function postEditcamera(Request $request, $camera_id)
	{
		$this->validate($request, [
			'name' => 'required',
			'ip_address' => 'required|ip',
		]);

		$Camera = Camera::findOrFail($camera_id);
		$Camera->name = $request->name;
		$Camera->ip_address	= $request->ip_address;
		$Camera->active	= $request->get('active','0');

		$Camera->save();

		return redirect('/sets/view/'.$Camera->set_id);
	}

	public function postDeleteCamera(Request $request,$camera_id)
	{
		Camera::where('id',$camera_id)->delete();
		return response()->json(true);
	}

}
