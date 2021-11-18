<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Response;
use DB;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class UserController extends Controller
{
    public function index()
    {
        return view('welcome');
    }
    /**
     *  URL:/api/getUsers
     *  METHOD: GET
     */
    public function getUsers()
    {
        try {
            $users = User::order()->paginate(5);
            
            return response()->json(
                [
                    'status' => 'SUCCESS',
                    'data' => [
                        'users' => $users
                    ],
                    'code' => HttpFoundationResponse::HTTP_OK
                ],
                HttpFoundationResponse::HTTP_OK
            );
        } catch (Exception $e) {
            return response()->json(
                [
                    'status' => 'ERROR',
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'trace' => $e->getTrace()
                ],
                HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
    /**
     *  URL:/api/save
     *  METHOD: POST
     *  PARAMETERS: name {string}, email {string}, password {string}, birthdate {date}
     */
    public function save(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'birthdate' => 'required'
            ]);
            $user = User::create($request->all());
            $user->password = Hash::make($request->password);
            $user->save();
        
            return response()->json(
                [
                    'status' => 'SUCCESS',
                    'data' => [
                        'user' => $user
                    ],
                    'code' => HttpFoundationResponse::HTTP_OK
                ],
                HttpFoundationResponse::HTTP_OK
            );
        } catch (Exception $e) {
            return response()->json(
                [
                    'status' => 'ERROR',
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'trace' => $e->getTrace()
                ],
                HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
    /**
     *  URL:/api/update
     *  METHOD: POST
     *  PARAMETERS: name {string}, email {string}, password {string}, birthdate {date}
     */
    public function update(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'birthdate' => 'required'
            ]);
        
            $user = User::findOrFail($request->id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->birthdate = $request->birthdate;
            $user->active = $request->active;
            $user->save();
        
            return response()->json(
                [
                    'status' => 'SUCCESS',
                    'data' => [
                        'user' => $user
                    ],
                    'code' => HttpFoundationResponse::HTTP_OK
                ],
                HttpFoundationResponse::HTTP_OK
            );
        } catch (Exception $e) {
            return response()->json([$e->getMessage()],
                HttpFoundationResponse::HTTP_OK
            );
        }
    }
    /**
     *  URL:/api/delete
     *  METHOD: POST
     *  PARAMETERS: id {int}
     */
    public function delete(Request $request)
    {
        try {
            $user = User::findOrFail($request->id);
            $user->delete();
        
            return response()->json(
                [
                    'status' => 'SUCCESS',
                    'data' => [
                        'user' => $user
                    ],
                    'code' => HttpFoundationResponse::HTTP_OK
                ],
                HttpFoundationResponse::HTTP_OK
            );
        } catch (Exception $e) {
            return response()->json(
                [
                    'status' => 'ERROR',
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'trace' => $e->getTrace()
                ],
                HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
