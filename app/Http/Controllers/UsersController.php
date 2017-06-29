<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;
use App\Mail\AccountDeleted;
use Mail;
use App\API\ApiHelper;
use Carbon\Carbon;

class UsersController extends Controller
{
    
         use ApiHelper;

    	public function index()
    	{
   //  		$users=User::all();
			// die($users);
			if (Auth::check()) {
            // The user is logged in...
				return back();

            }
    		return view('welcome');
    	}

    	public function show(User $name)
    	{
    		
			
    		return view('welcome');

    	}

        public function profile()
        {
            return view('profile', array('user'=>Auth::user()));
        }

        public function update_avatar(Request $request)

        {
            

            $imageData = $request->get('image');
          
            $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
             Image::make($request->get('image'))->resize(300, 300)->save(public_path('img/').$fileName);

             $request->user();
             $request->user()->avatar='/img/'.$fileName;
             $request->user()->save();

             return response()->json(['error'=>false]);

            
        }

        public function delete_account(Request $request)
        {
           $id=$request->user()->id;
           $request->user()->destroy($id); 
             // $user = Auth::user();

             // Auth::logout();

             // if ($user->delete()) {

             //    $content = [
             //    'title'=> 'Account Deleted', 
             //    'body'=> 'As per your request we have deleted your account. Feel free to resume anytime,',
             //    'button' => 'Click Here'
             //    ];

                
             //    // Mail::to($user->email)->send(new AccountDeleted($content));

             //    return redirect(route('login'))->with('status','Your account has been deleted successfully. Sorry to see you go!');

             // }
        }




}
