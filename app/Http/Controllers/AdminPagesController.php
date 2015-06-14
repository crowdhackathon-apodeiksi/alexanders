<?php namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class AdminPagesController extends Controller {
    protected $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->user = \Auth::user();
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function home()
    {

        return view('admin.home');
    }

    /**
     * Show all existing receipts.
     *
     * @return Response
     */
    public function receipts()
    {
        $receipts = Receipt::paginate(10);
        return view('admin.receipts', compact('receipts'))->with('page_title', 'Όλες οι αποδείξεις των χρηστών');
    }

    /**
     * Show all existing categories.
     *
     * @return Response
     */
    public function categories()
    {
        $categories = Category::groupBy('name')->paginate(10);
        foreach ($categories as $category)
        {
            $category->receipts_count = 0;
            Category::whereName($category->name)->get()->each(function ($cat) use ($category)
            {
                $category->receipts_count += $cat->receipts()->count();
            });
        }
        return view('admin.categories', compact('categories'))->with('page_title', 'Όλες οι κατηγορίες των χρηστών');
    }


    /**
     * Show all receipts of a specific Category.
     *
     * @param  int  $name
     * @return Response
     */
    public function browseCategory($name)
    {
        $categories =Category::whereName($name)->get();
        $receipts = Collection::make();
        $categories->each(function($category) use ($receipts){
            $category->receipts->each(function($receipt) use ($receipts){
                $receipts->push($receipt);
            });
        });
        return view('admin.receipts', compact('receipts'))->with('page_title', $name);
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}
