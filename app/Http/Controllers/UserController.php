<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('user.index', compact('users'));
    }

    public function create()
    {
        $user = new User();

        $title = 'Add User';

        return view('user.create', compact('user', 'title'));
    }


    public function save(Request $request, $id = null)
    {
        $user = $id ? User::findOrFail($id) : new User();

        $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'password' => ['required']

            
			
        ]);

        $user->name        = $request->name;
        
        $user->password = $request->password;
        $user->email = $request->email;
        

        $user->save();

        return redirect()
            ->route('chat.index')
            ->with('success', 'User Saved Successfully');
    }




    public function datatable(Request $request)
    {
        $query = User::query();


        

        $total = $query->count();

        if ($request->has('order')) {
            $columns = $request->columns;
            foreach ($request->order as $order) {
                $columnName = $columns[$order['column']]['data'];
                $dbColumn   = match ($columnName) {
                    'name'        => 'name',
                    'email' => 'email',
                    'password' => 'password',
                    default       => 'id',	
                };
                $query->orderBy($dbColumn, $order['dir']);
            }
        } else { 
            $query->orderBy('id', 'desc');
        }

        $length = $request->input('length', 10);
        $start  = $request->input('start', 0);
        $user  = $query->skip($start)->take($length)->get();

        $data = $user->map(function ($user) {
		return [
			'id' => $user->id,
		
			'name' => $user->name,
			'email' => $user->email,
			'password' => $user->password,
		];
	});
		
		

        return response()->json([
            'draw'            => $request->input('draw', 1),
            'recordsTotal'    => $total,
            'recordsFiltered' => $total,
            'data'            => $data
        ]);
    }
}
