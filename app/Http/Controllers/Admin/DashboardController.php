<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function register(){
        $users= User::all();
        return view('admin.register')->with('users',$users);
    }


    public function registeredit(Request $request,$id)
            {
                    $users =User::findOrFail($id);
                    return view('admin.register-edit')->with('users',$users);
            }


     public function registerupdate(Request $request, $id) {
        $users= User::find($id);
        $users->name= $request->input('username');
        $users->role_id= $request->input('role_id');
        $users->update();
            
        return redirect('/admin/role-register')->with('status','Your Users Role is updated!');
            
        }

        
    public function registerdelete($id){
        $users= User::findOrFail($id);
        $users->delete();
            
        return redirect('/admin/role-register')->with('status','Your User has been  deleted!');
            
     }

    
}
