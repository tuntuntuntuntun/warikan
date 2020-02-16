<?php

namespace App\Http\Controllers;

use App\User;
use App\Bill;
use App\PaymentUser;
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
        $bills = Bill::all();
        $payment_users = PaymentUser::all();


        if (!$bills->isEmpty()) {
            $receive = 0;

            // 受け取る金額を求める
            foreach ($bills as $bill) {
                // ログインユーザーののみ計算
                if ($bill->user_id === Auth::id()) {
                    $count_user = PaymentUser::where('bill_id', $bill->id)->count();
    
                    $count_people = $count_user + 1;
    
                    $receive += round($bill->total - $bill->total / $count_people);
                }
            }

            
        }


        // 割り勘をした相手を求める      
        foreach ($bills as $bill) {
            $payment_users = PaymentUser::all();
        }

        return view('bill/index', [
            'payment_users' => $payment_users,
            'bills' => $bills,
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
        $bill = new Bill();

        $bill->title = $request->title;
        $bill->total = $request->total;
        $bill->payment_users()->bill_id = $bill->id;

        Auth::user()->bills()->save($bill);

        foreach ($request->to_user_id as $user_id) {
            PaymentUser::create(['bill_id' => $bill->id, 'user_id' => $user_id]);
        }

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
        return redirect()->route('bill.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Bill $bill)
    {
        $bills = Bill::all();
        $users = User::all();

        foreach ($bills as $bill) {
            $to_user_ids[] = $bill->user_id;
        }

        return view('bill/edit', [
            'users' => $users,
            'bill' => $bill,
            'to_user_ids' => $to_user_ids,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bill $bill)
    {
        $bill->title = $request->title;
        $bill->total = $request->total;
        
        $bill->to_user_id = $request->to_user_id;

        $bill->save();

        return redirect()->route('bill.index');
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
