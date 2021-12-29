<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use File;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
      //http://127.0.0.1:8000/api/products
    public function index()
    {
        // return 'Hi from index function in ProductController';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return 'hi from create in productcontroller' ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //http://127.0.0.1:8000/api/products
    public function store(Request $request) //add a new product
    {
        //id of current auth user = creator_id and owner_id
        $rules =
        [
            'name' => 'required|string',
            'image' => 'required|file',
            'type' => 'required|string',
            'description' => 'required|string',
            'price' => 'required',
        ] ;
        $validator = Validator::make($request->all(),$rules) ;
        if($validator->fails())
        {
            return $validator->errors();
        }
        else
        {
            $id = Auth::user()->id;
            /****************image************************/
            if( $request->hasFile('image') )
            {
                $validator_2 = $request->validate([
                    'image' => 'mimes:jpeg,bmp,png,jpg' // Only allow .jpg, .bmp and .png file types.
                ]);
                //save image in folder
                $file_extention = $request->image->getClientOriginalExtension();
                $file_name = time(). '.' .$file_extention;
                $file_path = 'images/products' ;  //get image path
                $request->image->move($file_path,$file_name);
            }

            $product = Product::create([
            'name' => $request->name ,
            'image' => $file_name,
            'type' => $request->type ,
            'description' => $request->description,
            'creator_id' => $id,
            'owner_id' => $id,
            'price' => $request->price ,
            ]) ;
            return response(
                [
                    'message' => 'Product added successfully',
                    'product' => $product
                ]);
        }
        // return 'hi from stor in productcontroller' ;
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
     * @param  int  $id -> id of the clicked product
     * @return \Illuminate\Http\Response
     */
    //edit a product get method
    public function edit($id)    //http://127.0.0.1:8000/api/products/{id}/edit
    {
        $products = Product::find($id) ;
        // return view('prducts.edit',compact($products));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)   //http://127.0.0.1:8000/api/products/{id}  put
    {
        // $authuserid = auth('sanctum')->user()->id;  //also true
        $authuserid = Auth::user()->id;
        $products = Product::find($id) ;
        if ( Product::where('id','=',$id)->exists() )
        {
            if ( $authuserid == $products->creator_id && $authuserid == $products->owner_id )
            {
                $rules =
                [
                    'name' => 'required|string',
                    'type' => 'required|string',
                    'description' => 'required|string',
                    'price' => 'required',
                ] ;
                $validator = Validator::make($request->all(),$rules) ;
                if($validator->fails())
                {
                    return $validator->errors();
                }
                else
                {
                    $products->name = $request->name ;
                    $products->type = $request->type ;
                    $products->description = $request->description;
                    $products->price = $request->price ;
                    $products->update();
                    return response(
                        [
                            'message' => 'Product updated successfully',
                            'product' => $products
                        ]);
                }
            }
            else
            {
            return 'some thing went wrong' ;
            }
        }
        else
        {
            return 'some thing went wrong' ;
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id of product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)    //http://127.0.0.1:8000/api/products/{id}  get
    {
        $authuserid = Auth::user()->id;
        $products = Product::find($id) ;
        if ( Product::where('id','=',$id)->exists() )
        {
            if ( $authuserid == $products->creator_id && $authuserid == $products->owner_id )
            {
                //delete image
                $path = 'images/products/'.$products->image;
                if ( File::exists($path) )
                {
                    File::delete($path);
                }
        
                $products->delete();
                return 'product deleted successfully';
            }
            else
            {
                return 'some thing went wrong' ;
            }
        }
        else
        {
            return 'some thing went wrong' ;
        }
    }
}
