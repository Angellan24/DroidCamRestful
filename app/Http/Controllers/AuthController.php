<?php

namespace App\Http\Controllers;
use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\User;
use Dotenv\Result\Success;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register','index','logout','updatename','updateaddress','updatedevice','delete']]);
    }

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
 
      public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        if ($token = Auth::guard('api')->attempt($credentials)) {
             return $this->respondWithToken($token);
        }
  
        return response()->json(['status'=> False, 'error' => 'Unauthorized']);
   }



    public function register(Request $request)
    {
        $record = new user;
        $record->name = $request->name;
        $record->email = $request->email;
        $record->address=$request->address;
        $record->device=$request->device;
        $record->password = Hash::make($request->password);
        $record->save();
        return response()->json(['status' => true, 'message'=>'User created']);
    }
  

   
   

   
  

    public function updatename (Request $request, $id)
    {
        try{
           
            User::findOrFail($id)
            ->update(['name'=>$request->name]);
           

            return response()->json(array(
                    'user' => User::findOrFail($id)));
         
        }catch(\Exception $e){
            return response()->json(['status'=>'Fail']);
        }
    }
    //update address
    public function updateaddress (Request $request, $id)
    {
        try{
           
            User::findOrFail($id)
            ->update(['address'=>$request->address]);
           

            return response()->json(array(
                    'user' => User::findOrFail($id)));
         
        }catch(\Exception $e){
            return response()->json(['status'=>'Fail']);
        }
    }
    //update device
    public function updatedevice (Request $request, $id)
    {
        try{
           
            User::findOrFail($id)
            ->update(['device'=>$request->device]);
           

            return response()->json(array(
                    'user' => User::findOrFail($id)));
         
        }catch(\Exception $e){
            return response()->json(['status'=>'Fail']);
        }
    }
    //delete user
    public function delete($id)
    {
        try{
            $record = User::FindOrFail($id);
            $record -> delete();
            return response()->json(['status' => true, 'message'=>'Profile Deleted']);
        }catch(\Exception $e){
            return response()->json(['status'=>'Fail']);
        }
    }
   
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' =>auth('api')->user()
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }
}   