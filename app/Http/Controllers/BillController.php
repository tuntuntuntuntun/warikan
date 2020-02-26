<?php

namespace App\Http\Controllers;

use App\User;
use App\Bill;
use App\PaymentUser;
use App\Http\Requests\CreateBill;
use App\Http\Requests\EditBill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillController extends Controller
{
    public function __construct(){
      $this->middleware('can:update,bill')->only('edit', 'update');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $bills = Bill::all();
        $payment_users = PaymentUser::all();


        if (!$bills->isEmpty()) {
            // 初期化
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


            // 支払う金額
            foreach ($payment_users as $payment_user) {
                if ($payment_user->user_id === Auth::id()) {
                    // お金を払ってもらったbillのidを取得
                    $my_bills[] = Bill::where('id', $payment_user->bill_id)->get();
                }
            }

            // 初期化
            foreach ($bills as $bill) {
                if (isset($my_bills)) {
                    foreach ($my_bills as $my_bill) {
                        if ($my_bill[0]->id === $bill->id) {
                            $to_user[$my_bill[0]->user_id] = 0;
                        }
                    }
                }
            }

            foreach ($bills as $bill) {
                if (isset($my_bills)) {
                    foreach ($my_bills as $my_bill) {
                        if ($my_bill[0]->id === $bill->id) {
                            // 参加した割り勘の人数を求める
                            $num_of_people = PaymentUser::where('bill_id', $my_bill[0]->id)->count() + 1;
    
                            // その割り勘で支払う金額を求める
                            $should_pay = round($bill->total / $num_of_people);
    
                            // user_idをキーにした連想配列へ
                            $to_user[$my_bill[0]->user_id] += $should_pay;
    
                        }
                    }
                }
            }
        }

        // 割り勘をした相手を求める      
        foreach ($bills as $bill) {
            $payment_users = PaymentUser::all();
        }

        
        $duplication = 0;
        if (isset($my_bills)) {
            foreach ($my_bills as $my_bill) {
                if($my_bill[0]->user_id === $duplication) {
                    $my_payments[] = $my_bill;
                }
                $duplication = $my_bill[0]->user_id;
            };
        }

        
        if (isset($my_payments)) {
            return view('bill/index', [
                'users' => $users,
                'bills' => $bills,
                'receive' => $receive,
                'to_user' => $to_user,
                'payment_users' => $payment_users,
                'my_payments' => $my_payments,
            ]);
        } else {
            return view('bill/index', [
                'users' => $users,
                'bills' => $bills,
                'receive' => $receive,
                'payment_users' => $payment_users,
            ]);
        }
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
        $users = User::all();
        $payment_users = PaymentUser::all();

        // チェックボックスをcheckedにするため
        foreach ($payment_users as $payment_user) {
            if ($payment_user->bill_id === $bill->id) {
                $to_user_ids[] = $payment_user->user_id;
            }
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
    public function update(EditBill $request, Bill $bill)
    {
        Bill::where('id', $bill->id)->update(['title' => $request->title]);
        Bill::where('id', $bill->id)->update(['total' => $request->total]);

        // payment_usersテーブルを更新
        PaymentUser::where('bill_id', $bill->id)->delete();

        foreach ($request->to_user_id as $user_id) {
            PaymentUser::create(['bill_id' => $bill->id, 'user_id' => $user_id]);
        }

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
