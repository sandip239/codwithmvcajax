<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\Studunt;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class usercontroller extends Controller
{
    public function registerView()
    {
      return view('register');
    }
    public function register(request $request)
    {
      $user = new User();
      $user->name = $request->input('name');
      $user->email = $request->input('email');
      $user->password = Hash::make($request->input('password'));
      $user->save();
      return redirect()->route('loginview');
    }

    public function loginView()
    {
       return view('login');
    }

    public function login(request $request)
 {
    $email = $request->input('email');
    $password = $request->input('password');
    // dd($email);
    $user = DB::table('users')->where('email', $email)->first();


    if ($user && Hash::check($password, $user->password)) {
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            return redirect()->route('studuntview');
        }
    } else {
        return redirect()->route('loginview')->withErrors(['msg' => 'User Not Found']);
    }
 }

    public function studuntView()
    {


        $studunt = Studunt::all();
        return view('deshboard',compact('studunt'));
    }

    public function studuntRegisterview()
    {
        $countries = Country::all();
        return view('studuntregister',compact('countries'));
    }

    public function studuntRegister(request $request)
    {
        $countryId = request()->input('country');
        $stateId = request()->input('state');
        $cityId = request()->input('city');

        $countryName = Country::where('id', $countryId)->value('name');
        $stateName = State::where('id', $stateId)->value('name');
        $cityName = City::where('id', $cityId)->value('name');


       $user = new Studunt();
       $user->name = $request->input('name');
       $user->email = $request->input('email');
       $user->password = Hash::make($request->input('password'));
       $user->country =  $countryName;
       $user->state =  $stateName;
       $user->city =  $cityName;
       $user->save();
       return redirect()->route('studuntview');
    }

    public function edit($id)
 {
    $countries = Country::all();
    $State = State::all();
    $City = City::all();
      $user = Studunt::find($id);
      return view('edit',compact('user','countries','State','City'));
 }

 public function update(request $request)
 {
    $user = Studunt::find($request->input('id'));
    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $user->country = $request->input('country');
    $user->state = $request->input('state');
    $user->city = $request->input('city');
    $user->password = Hash::make($request->input('password'));
    $user->save();
    return redirect()->route('studuntview');
 }

 public function delete($id)
 {
    $user = Studunt::find($id);
    $user->delete();
    return redirect()->route('studuntview');
 }

    public function index()
    {
        $data['countries'] = Country::get(["name","id"]);
        return view('country-state-city',$data);
    }
    public function getState(Request $request)
    {
        $data['states'] = State::where("country_id",$request->country_id)
                    ->get(["name","id"]);
        return response()->json($data);
    }
    public function getCity(Request $request)
    {
        $data['cities'] = City::where("state_id",$request->state_id)
                    ->get(["name","id"]);
        return response()->json($data);
    }




}
