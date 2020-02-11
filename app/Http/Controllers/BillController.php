<?php

namespace App\Http\Controllers;

use App\User;
use App\Bill;
use App\Http\Requests\CreateBill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $bills = Bill::all();


        // $bill->to_user_idを配列に
        foreach ($bills as $bill) {
            $to_user_ids = explode(',', $bill->to_user_id);
        }

        // 割り勘相手の$user->nameを配列に
        foreach ($to_user_ids as $to_user_id) {
            foreach ($users as $user) {
                if ($to_user_id == $user->id) {
                    $to_user_names[] = $user->name;
                }
            }
        }


        // 割る人数を求める
        $count_people = count($to_user_names) + 1;

        // いくら支払ってもらう必要があるかをもとめる
        $receive = 0;

        foreach ($bills as $bill) {
            if (Auth::id() === $bill->user_id) {
                $receive += round($bill->total / $count_people);
            }
        }

        return view('bill/index', [
            'bills' => $bills,
            'to_user_names' => $to_user_names,
            'receive' => $receive,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();

        return view('bill/create', [
            'users' => $users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateBill $request)
    {
        $user = new User();
        $bill = new Bill();

        $bill->title = $request->title;
        $bill->total = $request->total;
        $bill->user_id = Auth::id();

        // 配列を文字列に変換
        $request->to_user_id = implode(',', $request->to_user_id);

        $bill->to_user_id = $request->to_user_id;

        $bill->save();

        return redirect()->route('bill.index');
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
}
