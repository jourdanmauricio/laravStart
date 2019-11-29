<?php

namespace App\Http\Controllers\API;

use App\MlUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MlUserController extends Controller
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
        //        $this->authorize('isAdmin');
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor')) {

            return MlUser::latest()->paginate(5);
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
        $mluser = auth('api')->user();
        //        return $mluser->id;
        return MlUser::updateOrCreate(
            ['user_id' => $mluser->id],
            [
                'user_id' => $mluser->id,
                'ml_id' => $request['ml_id'],
                'nickname' => $request['nickname'],
                'registration_date' => $request['registration_date'],
                'first_name' => $request['first_name'],
                'last_name' => $request['last_name'],
                'gender' => $request['gender'],
                'country_id' => $request['country_id'],
                'email' => $request['email'],
                'identification_number' => $request['identification_number'],
                'identification_type' => $request['identification_type'],
                'address' => $request['address'],
                'city' => $request['city'],
                'state' => $request['state'],
                'zip_code' => $request['zip_code'],
                'phone_area_code' => $request['phone_area_code'],
                'phone_extension' => $request['phone_extension'],
                'phone_number' => $request['phone_number'],
                'phone_verified' => $request['phone_verified'],
                'alt_phone_area_code' => $request['alt_phone_area_code'],
                'alt_phone_extension' => $request['alt_phone_extension'],
                'alt_phone_number' => $request['alt_phone_number'],
                'user_type' => $request['user_type'],
                'logo' => $request['logo'],
                'points' => $request['points'],
                'site_id' => $request['site_id'],
                'permalink' => $request['permalink'],
                'seller_experience' => $request['seller_experience'],
                'seller_reputation_level_id' => $request['seller_reputation_level_id'],
                'seller_power_seller_status' => $request['seller_power_seller_status'],
                'seller_transactions_canceled' => $request['seller_transactions_canceled'],
                'seller_transactions_completed' => $request['seller_transactions_completed'],
                'seller_transactions_period' => $request['seller_transactions_period'],
                'seller_ratings_negative' => $request['seller_ratings_negative'],
                'seller_transactions_total' => $request['seller_transactions_total'],
                'seller_ratings_neutral' => $request['seller_ratings_neutral'],
                'seller_ratings_positive' => $request['seller_ratings_positive']
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MlUser  $mlUser
     * @return \Illuminate\Http\Response
     */
    public function show(MlUser $mlUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MlUser  $mlUser
     * @return \Illuminate\Http\Response
     */
    public function edit(MlUser $mlUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MlUser  $mlUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MlUser $mlUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MlUser  $mlUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(MlUser $mlUser)
    {
        //
    }

    public function search()
    {

        if ($search = \Request::get('q')) {
            $mlusers = MlUser::where(function ($query) use ($search) {
                $query->where('first_name', 'LIKE', "%$search%")
                    ->orWhere('last_name', 'LIKE', "%$search%")
                    ->orWhere('nickname', 'LIKE', "%$search%")
                    ->orWhere('city', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%");
            })->paginate(5);
        } else {
            $mlusers = MlUser::latest()->paginate(5);
        }

        return $mlusers;
    }
}
