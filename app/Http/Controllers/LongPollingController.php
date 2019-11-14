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




        session_write_close();
        ignore_user_abort(false);
        set_time_limit(1);


        if (empty($request->cookie('user'))){


            $user = rand(0,10000000);
            // send to the browser

            $cookie=cookie('user',$user,500); //REMOVE


            //REMOVE
            // save in global variable


            // add user to the database

            $userNew = new User;
            $userNew->username = $request->username;
            $userNew->last_sent_id = $user;
            $userNew->save();
            return response([
                [
                    'message' => 'No Message',
                    'username' => '',
                    'time' => '',
                ]
            ])->cookie($cookie);

            // first request does not do anything than creating the cookie

        }


        $flagUpdate = DB::table('users')
                    ->where('username',$request->username)
                    ->update(['last_sent_id' => $request->cookie('user')]);

        while(true){

            sleep(1); 

            $result = DB::table('messages')
                    ->leftJoin('users', 'users.last_sent_id', '=', 'messages.user_id')
                    ->select('users.username','messages.message','messages.created_at as time')
                    ->orderBy('messages.id')
                    ->get();


            if (!$result){
                return json_encode([
				            [
                        'message' => 'No Message',
                        'username' => '',
                        'time' => '',
                    ]
			          ]);
            }
            return $result;

        }

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
        return back()->withInput(['username' => $request->username]);

    }

}
