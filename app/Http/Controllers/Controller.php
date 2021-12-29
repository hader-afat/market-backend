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
        // dd($q);
        
        if($q != "")
        {
            // dd('ddddddddd');
            $user = Product::where ( 'name', 'LIKE', '%' . $q . '%' )
                        // ->select('*')
                        ->orWhere ( 'description', 'LIKE', '%' . $q . '%' )
                        ->get ();
            // dd($user);
            if (count ( $user ) > 0)
            {
                return $user;
                // dd('enter iiiiiiiiiif') ;
                // return view('search',compact($user));
                // return view ( 'search' )->withDetails ( $user )->withQuery ( $q );
            }
               
            else
            {
                return 'noooo item' ;
                // dd('enter ellllllllllllllse');
                // return view ( 'search' )->withMessage ( 'No Details found. Try to search again !' );
                // return view('welcome'); //replace view of welcome with home page
            }
                
        }
        return 'yalahoooooooooooooy' ;
        // return view ( 'welcome' );
    }

}
