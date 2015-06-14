<?php namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use JWTAuth;
use PhpParser\Node\Expr\ArrayItem;

class ReceiptsCategoriesApiController extends Controller {
    /**
     * Display a listing of the resource.
     * TODO na to sizitisoume pos to theleis
     * @return Response
     */
    public function index()
    {
        $user=JWTAuth::parseToken()->authenticate();
        $result=new Collection;
        foreach ($user->receipts as $receipt)
        {
            foreach ($receipt->categories as $category)
            {
                $a=(object)array();
                $a->receipt_id = $receipt->id;
                $a->category_id = $category->id;
                $result->push($a);
            }

        }

        return $result;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $receipt_id
     * @param $category_id
     * @return Response
     */
    public function store($receipt_id, $category_id)
    {
        $user=JWTAuth::parseToken()->authenticate();
        $receipt=Receipt::find($receipt_id);
        $category=Category::find($category_id);
        //if user has already assigned this category to the receipt
        if(!$receipt->hasCategory($category)){
            $owner=['user_id' => $user->id];
            $receipt->categories()->attach($category->id, $owner);
        }

        return 'success';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $receipt_id
     * @param $category_id
     * @return Response
     * @internal param int $id
     */
    public function destroy($receipt_id, $category_id)
    {
        $receipt=Receipt::find($receipt_id);
        $category=Category::find($category_id);
        if($receipt->hasCategory($category)){
            $receipt->categories()->detach($category->id);
        }
        return 'success';
    }

}
