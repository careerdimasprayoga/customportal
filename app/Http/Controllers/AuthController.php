<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Customer;
use Validator;
use Hash;

class AuthController extends Controller
{
  public function cek_marking(Request $request)
  {
    $kode_mark=$request['kode_mark']; 
    $cek_marking = Customer::select('kode')
    ->where('kode', '123/'.$kode_mark)
    ->get();
    return $cek_marking;
  }
  /**
  * Create user
  *
  * @param  [string] name
  * @param  [string] email
  * @param  [string] password
  * @param  [string] password_confirmation
  * @return [string] message
  */
  public function register(Request $request)
  {
    // Check Marking
    $cek_marking = Customer::select('kode')
    ->where('kode', '123/'.$request->kode)
    ->get();
    if (count($cek_marking) >= 1) {
      return response()->json(array(
        'code'      =>  401,
        'message'   =>  'ID Marking sudah digunakan!'
      ), 201);
      die;
    }

    // Validation
    $validator = Validator::make($request->all(), [
      'kode' => 'required|unique:customer',
      'nama' => 'required|string',
      'email' => 'required|string',
      'password' => 'required|string',
      'ktp' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      'telepon' => 'required|string',
      'whatsapp' => 'required',
      'perusahaan' => 'required|string',
      'alamat' => 'required|string',
      'rekening' => 'required|string',
      'username' => 'required|string'
    ]);
    
    // KTP File rename
    $ktpName = time().'.'.$request->ktp->extension();   
    $request->ktp->move(public_path('images'), $ktpName);

    $customer = Customer::create([
      'kode'     => '123/'.$request->kode,
      'nama'     => $request->nama,
      'email'     => $request->email,
      'password'   => bcrypt($request->password),
      'harga_lama' => '1',
      'jtempo' => 'dummy',
      'whatsapp2' => '123',
      'wakonf' => '123',
      'wakonf2' => '123',
      'online' => '1',
      'ktp' => $ktpName ,
      'telepon' => $request->telepon,
      'whatsapp' => $request->whatsapp,
      'perusahaan' => $request->perusahaan,
      'alamat' => $request->alamat,
      'rekening' => $request->rekening,
      'username' => $request->username
    ]);
    if($customer) {
      return response()->json(
        ['message' => 'Registrasi Sukses'], 201);
    } else {
      return response()->json(
        ['message' => 'Registrasi Gagal'], 400);
    }
  }

  /**
  * Login user and create token
  *
  * @param  [string] email
  * @param  [string] password
  * @param  [boolean] remember_me
  * @return [string] access_token
  * @return [string] token_type
  * @return [string] expires_at
  */
  public function login(Request $request) {
    $cek_user = Customer::select('id','kode','email','nama','username','password')
    ->where('kode', '123/'.$request->kode_marking)
    ->get();
    if (count($cek_user) >= 1) {
      if (Hash::check($request->password, $cek_user[0]->password)) {
        $token = bin2hex(random_bytes(20));
        return response()->json(array(
          'userData' => $cek_user,
          'code' => 200,
          'message' => 'Login berhasil!',
          'accessToken' => $token,
          'refreshToken' => $token,
          'token_type' => 'Bearer'
        ), 200);
      } else {
        return response()->json(array(
          'code'      =>  201,
          'message'   =>  'Password salah!'
        ), 201);
      }
      
    } else {
      return response()->json(array(
        'code'      =>  201,
        'message'   =>  'Akun tidak ditemukan!'
      ), 201);
    }
  }
  // public function login(Request $request)
  // {
  //   $request->validate([
  //     'email' => 'required|string|email',
  //     'password' => 'required|string',
  //     'remember_me' => 'boolean'
  //   ]);
  //   $credentials = request(['email', 'password']);
  //   if(!Auth::attempt($credentials))
  //     return response()->json([
  //       'message' => 'Unauthorized'
  //     ], 401);
  //   $user = $request->user();
  //   $tokenResult = $user->createToken('Personal Access Token');
  //   $token = $tokenResult->token;
  //   if ($request->remember_me)
  //     $token->expires_at = Carbon::now()->addWeeks(1);
  //   // $token->save();
  //   return response()->json([
  //     'accessToken' => $tokenResult->accessToken,
  //     'refreshToken' => $tokenResult->accessToken,
  //     'userData' => $user,
  //     'token_type' => 'Bearer',
  //     'expires_at' => Carbon::parse(
  //       $tokenResult->token->expires_at
  //     )->toDateTimeString()
  //   ]);
  // }
  
}