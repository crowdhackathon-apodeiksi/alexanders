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

Route::get('ocr', function()
{
    $text="






Y ‘ ' ; a , f
¢ . - f
nmJ 7 ,- ‘ﬁ:

' ‘0Ptu- g %

EVXAF'ITOY

OPOAOHKHKﬁOAHEH'?Ewen ;
BOVLEVHRD

A,KH¢ETEPIR
:RHHflﬂNNIAOY EAENH

VHRH/Apoy 50 ﬂEYKR
QEZ/KH Kev E QEXIKHE
00M 11310256?
THA12310A6761/1

EYXRPXETOYME
13} 3‘00 13.00%
13» 3‘00 13.00:

RP.TEMRXIHN 2

2000 g W
HAHPRHH ME r1000 5&2

HH.HP‘AEATIRN LEUARN
mpooa ﬂP.AEAT EEOARN 35800

KVPIRKH 31~05~15 0P0 20138
XEWINHXl HMEm
HPIGMOZ MHIPHOV 001 14001300 v
HHwa:033t51540210000L00r003I060
D22081B3RH2\ 0

umammummLuIumﬁﬁmuxmm
rI”msulmumumu\\\\

 ‘ w
‘5“ sizuﬁ :0

r. m 00 000710020:





«‘1








";
    $text= str_replace('?', '7', $text);

    preg_match_all('![0-9]{9}!', $text, $afmes);
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