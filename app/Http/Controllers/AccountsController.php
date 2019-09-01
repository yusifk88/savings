<?php

namespace App\Http\Controllers;
use App\Payment;
use App\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $acounts = Account::orderBy('fname','asc')->get();
        return response($acounts);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $createAccount = Account::create([
            'fname' => $request['fname'],
            'lname' => $request['lname'],
            'title' => $request['title'],
            'sex' => $request['sex'],
            'hometown' => $request['hometown'],
            'dob' => $request['dob'],
            'address' => $request['address'],
            'phone' => $request['phone'],
            'bank' => $request['bank'],
            'accno' => $request['accno'],
            'occupation' => $request['occupation'],
            'email' => $request['email'],
            'passport' => Storage::url($request->file('passport')->store('public/passports'))

        ]);

        if ($createAccount){
            return response($createAccount);

        }else{
            return response(['error'=>'This E-mail Address already exist']);

        }



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

       $acc = Account::find($id);

        $conts  = Payment::where('ac_id',$id)->get();
        $balance = Payment::where('ac_id',$id)->sum('amount');
        return response(['account' => $acc, 'conts' => $conts,'balance'=>$balance]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function edit(Account $account)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Account $account)
    {

        if(!$request->file('passport')){

          Account::where('id',$request['ac_id'])
                ->update([
                'fname' => $request['fname'],
                'lname' => $request['lname'],
                'sex' => $request['sex'],
                'address' => $request['address'],
                'phone' => $request['phone'],
                'bank' => $request['bank'],
                'accno' => $request['accno'],
                'email' => $request['email'],
                'title' => $request['title'],
                'occupation' => $request['occupation'],
                'dob' => $request['dob']

                    ]);

        }else{

          Account::where('id',$request['ac_id'])
                ->update([
                    'fname' => $request['fname'],
                    'lname' => $request['lname'],
                    'sex' => $request['sex'],
                    'address' => $request['address'],
                    'phone' => $request['phone'],
                    'bank' => $request['bank'],
                    'accno' => $request['accno'],
                    'email' => $request['email'],
                    'title' => $request['title'],
                    'occupation' => $request['occupation'],
                    'dob' => $request['dob'],
                    'passport' => Storage::url($request->file('passport')->store('public/passports'))

                ]);

        }

         $upaccount = Account::find($request['ac_id']);

        return response($upaccount);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account)
    {
        //
    }
}
