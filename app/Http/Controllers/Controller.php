<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class Controller extends BaseController
{
    // use AuthorizesRequests, 
    use DispatchesJobs, ValidatesRequests;

    public function index()  //show all products for sale in his region
    {
        
        // if(Auth::check())
        // {
        //     return 'ahooooooooooo';
        //     // $id = Auth::user()->id;
        //     // return $id;
        // }
        // else
        // {
            $products = Product::where('available','=',1)
                ->select('id','name','description','type','price')
                ->get();
            return response()->json($products);
        // }
        

        // $products = Product::where('available','=',1)
        //         ->select('id','name','description','type','price')
        //         ->get();
        // return response()->json($products);

        // $productconnection = new Product;
        // $products_1 = $productconnection->setConnection('mysql');
        // $products_1 = $productconnection->where('available','=',1)
        //         ->select('id','name','description','type','price')
        //         ->get();
        // $products_2 = $productconnection->setConnection('mysql_2');
        // $products_2 = $productconnection->where('available','=',1)
        //         ->select('id','name','description','type','price')
        //         ->get();

        // return response()->json([$products_1,$products_2]);
        // return 'hiiiiiiiiiiii controller';
    }

    public function search(Request $request)
    {
        $q = $request->q ;
        if($q != "")
        {
            $user = Product::where ( [['name', 'LIKE', '%' . $q . '%'] , ['available' , '=' , 1]] )
                        ->orWhere ( [['description', 'LIKE', '%' . $q . '%'] , ['available' , '=' , 1]])
                        ->get ();
            if (count ( $user ) > 0)
            {

                return response($user);
            }
            
            else
            {
                return response([
                    "message" => 'NO item found'
                ]) ;
            }
                
        }
        return response([
            "message" => 'ERROR'
        ]) ;
    }

}
