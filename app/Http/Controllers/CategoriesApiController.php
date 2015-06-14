<?php namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Illuminate\Http\Request;
use JWTAuth;

class CategoriesApiController extends Controller {
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
        return $this->getUser()->categories()->orderBy('created_at', 'DESC')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //if user has already created this category then return it
        if($category = $this->getUser()->categories()->whereName($this->request->get('name'))->first()){
            return $category;
        }
        //else store the category
        $new_category = $this->prepareInputCategory();
        $category= Category::create($new_category);
        return $category;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $category=Category::findOrFail($id);
        $category->fill($this->prepareInputCategory());
        $category->save();
        return $category;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Category::findOrFail($id)->delete();
        return "Category with id $id has been deleted";
    }

    public function prepareInputCategory()
    {
        $new_category = $this->request->all();
        $new_category['user_id'] = $this->getUser()->id;
        return $new_category;
    }
    public function getUser(){
        return JWTAuth::parseToken()->authenticate();
    }
}
