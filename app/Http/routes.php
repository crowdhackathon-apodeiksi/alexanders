<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use App\Receipt;

Route::get('/', 'PagesController@index');
Route::get('/home', 'PagesController@index');

Route::get('/receipts', 'PagesController@receipts');
Route::get('/categories', 'PagesController@categories');
Route::get('/categories/{category}', ['as' => 'category.browse', 'uses' =>'PagesController@browseCategory']);


Route::get('admin', ['as' => 'admin.home', 'uses' => 'AdminPagesController@home']);
Route::get('admin/receipts', ['as' => 'admin.receipts', 'uses' => 'AdminPagesController@receipts']);
Route::get('admin/categories', ['as' => 'admin.categories', 'uses' => 'AdminPagesController@categories']);
Route::get('admin/categories/{category}', ['as' => 'admin.category.browse', 'uses' =>'AdminPagesController@browseCategory']);


Route::get('business', ['as' => 'business.home', 'uses' => 'BusinessPagesController@home']);
Route::get('business/receipts', ['as' => 'business.receipts', 'uses' => 'BusinessPagesController@receipts']);
Route::get('business/promotions', ['as' => 'business.promotions', 'uses' => 'BusinessPagesController@promotions']);
Route::get('business/promotions/create', ['as' => 'business.promotions.create', 'uses' => 'BusinessPagesController@createPromotion']);


Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

Route::any('jwt/create', ['uses' => 'TokensController@authenticate']);
Route::get('jwt', function(){
    $user = JWTAuth::parseToken();
    return $user->toArray();
});
Route::resource('api/me/receipts', 'ReceiptsApiController', ['except' => ['show', 'edit', 'create']]);
Route::resource('api/me/categories', 'CategoriesApiController', ['except' => ['show', 'edit', 'create']]);

Route::get('api/me/receiptscategories/', ['as' => 'api.me.receipts.categories.index', 'uses' => 'ReceiptsCategoriesApiController@index']);
Route::post('api/me/receipts/{receipt}/categories/{category}', ['as' => 'api.me.receipts.categories.store', 'uses' => 'ReceiptsCategoriesApiController@store']);
Route::delete('api/me/receipts/{receipt}/categories/{category}', ['as' => 'api.me.receipts.categories.destroy', 'uses' => 'ReceiptsCategoriesApiController@destroy']);


Route::resource('api/promotions', 'PromotionsController', ['only' => ['store', 'index']]);

Route::any('ocr', function()
{
    $a= Request::all();
    file_put_contents(public_path().'/images/malakies/input2.jpg',$a);
    return 'ok';
    $text="

GAZOO
KA®E MHAP
{TAP AH TOYPIZTIKH TEKNEKH
WYXAFQFIKH ENE
UEIPAIQI 111240121w A®HNA
THA:210341388&
A.®,M: 997793450 % A01: AﬂHNQN :1

HMEF’.: 14/06/2015 11:34:31
TPA11:DEL XEPB: 1AMEIO .
AHOAEIEH AIANIKHZ 1111AH£HX

A/A:87891
EIAOZ rlozor A;IA cb n A
E§5§E830 1,00 1,80 13
EKHTQZH 0,00
EYNOAO 1,80

EYXAPIXTOYME noAy



";
    $text= str_replace('?', '7', $text);
    $text= str_replace('&', '8', $text);

    preg_match_all('![0-9]{9}!', $text, $afmes);

    foreach ($afmes[0] as $afm)
    {
        if(strtolower($afm[0] != '1') && strtolower($afm[0] != '2')){
            echo $afm;
        }
//        if($afm<19999999 || $afm>299999999){
//            if($afm<111 || $afm>299999999)
//        }
    }

    preg_match_all('![0-9,]{3,5}!', $text, $posa);
    echo end($posa[0]);


    return 'ok';
    $afm=$afmes[0][0];
    return "Receipt afm: ".$afm;
    return 'end';
});






Route::get('export-routes', function()
{
    header('Content-Type: application/excel');
    header('Content-Disposition: attachment; filename="routes.csv"');

    $routes = Route::getRoutes();
    $fp = fopen('php://output', 'w');
    fputcsv($fp, ['METHOD', 'URI', 'NAME', 'ACTION']);
    foreach ($routes as $route) {
        fputcsv($fp, [head($route->methods()) , $route->uri(), $route->getName(), $route->getActionName()]);
    }
    fclose($fp);
});