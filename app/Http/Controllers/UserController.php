<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Product;
use App\Models\User;

class UserController extends Controller
{
    public function profile()
    {
        //get id of curent user
        $authuser = Auth::user();
        $rulesNotSolid = [
            'creator_id' => $authuser->id,
            'available' => 1,
        ];
        $rulesSolid = [
            'creator_id' => $authuser->id,
            'available' => 0,
        ];
        $rulesPurchased = [
            'available' => 0, //khlas 7ad ba3ha
            // 'creator_id' => != $id,
            'owner_id' => $authuser->id,
        ];
        $productNotSolid = Product::where($rulesNotSolid)
                            ->select('*')
                            ->get();
        $productSolid = Product::where($rulesSolid)
                            ->select('*')
                            ->get();
        $productPurchased = Product::where($rulesPurchased)
                            ->select('*')
                            ->get();

        // return $productPurchased;
        return response([
            'user' => $authuser,
            'not solid' => $productNotSolid,
            'solid' => $productSolid,
            'purchased' => $productPurchased,
        ]) ;
        //return its info $user and 3 lists
    }

    public function add_cash(Request $request)
    {
        $cash = $request->balance;
        $authuserid = Auth::user()->id ;
        $buyer = User::where('id',$authuserid)
            ->select('*')
            ->first();
        $buyer->update([
            'balance'=> $cash,
        ]);
        return $buyer;
    }
        /**
     * Display the specified resource.
     *
     * @param  int  $id id of product to be purchased
     * @return \Illuminate\Http\Response
     */
    public function purchase($id)
    {
        $authuserid = Auth::user()->id ;
        $products = Product::find($id) ;
        if ( $products )
        {
            $buyer = User::where('id',$authuserid)
            ->select('*')
            ->first();
            $buyerBalance = $buyer->balance;
            $p_price = $products->price;
            if ( ($buyerBalance >= $p_price) && ($products->available == 1) ) //m3ah flos w el product msh atba3t
            {
                //can buy it
                $buyerBalance = $buyerBalance - $p_price ;
                $buyer->balance = $buyerBalance ;
    
                $products->owner_id = $authuserid ;
                $products->available = 0 ;
    
                $p_creatorID = $products->creator_id ;
                $user = new User;
                $sellerUser = $user->where('id',$p_creatorID)
                ->select('*')
                ->first();
                $sellerBalance = $sellerUser->balance ;
                $sellerBalance = $sellerBalance + $p_price ;
                $sellerUser->balance = $sellerBalance ;
                $buyer->update([
                    'balance' => $buyerBalance,
                ]);
                $sellerUser->update([
                    'balance' => $sellerBalance,
                ]);
                $products->update([
                    'owner_id' => $authuserid,
                ]);
                return response([
                    "message" => "Purchase completed successfully",
                    "c_id" => $products->creator_id,
                    "o_id" => $products->owner_id,
                    "b_balance" => $buyer->balance,
                    "c_balance" => $sellerUser->balance,
                ]) ;
            }
            else
            {
                return response([
                    "message" => "Your balance is not enough to complete the purchase",
                ]) ;
            }
        }
        else
        {
            return response([
                "message" => "some thing went wrong",
            ]) ;
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return 'Hi from index function in UserController';
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
}
