<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\User;
use App\Message;


class LongPollingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function longpolling(Request $request)
    {
        //



        //REMOVE
        // session_write_close();
        ignore_user_abort(false);
        set_time_limit(1);


        if (empty($request->cookie('user'))){


            $user = rand(0,10000000);
            // send to the browser
            // setcookie('user', $user);
            $cookie=cookie('user',$user,5);


            //REMOVE
            // save in global variable


            // add user to the database

            $userNew = new User;
            $userNew->username=$request->username;
            $userNew->last_sent_id=$user;
            $userNew->save();
            return response('success')->cookie($cookie);
            //REMOVE
            // first request does not do anything than creating the cookie

        }

        while(true){

            sleep(2); // to lighten the infinite loop

            $result = DB::table('users as u')
                    ->join('messages', 'u.last_sent_id', '=', 'messages.user_id')
                    ->get();
            $mysqli -> query("UPDATE db_user_data SET last_sent_id = $lastId WHERE user = $user");

            return $result;

        }
        // REMOVE
        return "huh ? it works";
    }

    public function messages(Request $request)
    {
        //

        if(empty($request->messagesInput)){
            $request->messagesInput='No Message';
        }


        $messageNew = new Message;
        $messageNew->user_id=$request->cookie('user');
        $messageNew->message=$request->messagesInput;
        $messageNew->save();

    }

}
