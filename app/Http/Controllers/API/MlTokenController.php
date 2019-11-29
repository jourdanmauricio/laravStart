<?php

namespace App\Http\Controllers\API;

use App\MlToken;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class MlTokenController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //  $this->authorize('isAdmin');
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor')) {

            return MlToken::latest()->paginate(5);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        return MlToken::create([
            'access_token' => $request['access_token'],
            'token_type' => $request['token_type'],
            'expires_in' => $request['expires_in'],
            'scope' => $request['scope'],
            'bio' => $request['bio'],
            'user_id' => $request['user_id'],
            'refresh_token' => $request['refresh_token']

        ]);
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

    public function search()
    {

        if ($search = \Request::get('q')) {
            $tokens = Token::where(function ($query) use ($search) {
                $query->where('user_id', 'LIKE', "%$search%");
            })->paginate(5);
        } else {
            $tokens = Token::latest()->paginate(5);
        }

        return $tokens;
    }

    public function accesstoken(Request $request)
    {
        //  $this->authorize('isAdmin');
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor') || \Gate::allows('isUser')) {

            return MlToken::where('ml_user', $request->ml_user)->first();
        }
    }
}
