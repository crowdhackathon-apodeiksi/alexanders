<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Receipt;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use JWTAuth;
class ReceiptsApiController extends Controller {
    protected $user;
    protected $request;

    function __construct(Request $request)
    {
        $this->request = $request;
        $this->middleware('jwt.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->getUser()->receipts()->orderBy('created_at', 'DESC')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $new_receipt = $this->prepareInputReceipt();
        $receipt= Receipt::create($new_receipt);
        return $receipt;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $receipt=Receipt::findOrFail($id);
        $receipt->fill($this->prepareInputReceipt());
        $receipt->save();
        return $receipt;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Receipt::findOrFail($id)->delete();
        return "Receipt with id $id has been deleted";
    }

    /**
     * @return array
     */
    public function prepareInputReceipt()
    {
        $new_receipt = $this->request->all();
        $new_receipt['user_id'] = $this->getUser()->id;
        if($this->request->printed_at){
            $new_receipt['printed_at'] = Carbon::createFromTimestamp($this->request->printed_at);
        }
        return $new_receipt;
    }

    public function getUser(){
        return JWTAuth::parseToken()->authenticate();
    }
}
