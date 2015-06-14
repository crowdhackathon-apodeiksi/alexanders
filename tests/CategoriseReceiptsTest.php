<?php
use Laracasts\TestDummy\Factory;

class CategoriseReceiptsTest extends TestCase {
    protected $endpoint;
    protected $token;

    function __construct()
    {
        $this->endpoint='api/me/receipts';
        $this->token="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXUyJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6XC9cL2hvbWVzdGVhZC5hcHA6ODAwMFwvand0XC9jcmVhdGUiLCJpYXQiOiIxNDM0MjA5NDI3IiwiZXhwIjoiMTQzNDIxMzAyNyIsIm5iZiI6IjE0MzQyMDk0MjciLCJqdGkiOiJlMTMzZTg4MmI2NDkyZWMyMTU4OTZhNDY4OGMyMDYyYiJ9.ZWUzMGI5MTBjMzUwNGRiYmMzZjE2YjFkNTE3ZTZlZWU5Yzg0OTU4ZTlhYzM1MzBhYWE3OTA1MzhkNjI0NzhlMg";
    }
    /**
     * A functional test example.
     *
     * @return void
     */
    public function testReceiptCategoryAssign()
    {
        $receipt = Factory::create('App\Receipt');
        $categories = Factory::times(3)->create('App\Category');

        $owner=['user_id' => \App\User::first()->id];
        $receipt->categories()->attach($categories->lists('id'),$owner);

        foreach ($categories as $category)
        {
            $this->assertTrue($receipt->hasCategory($category));
        }

    }

    //Test Receipts Categories Through Api

    /**
     * Assign category to receipt test
     *
     */
    public function testCreateCategoryReceipt()
    {
        $receipt = Factory::create('App\Receipt');
        $category = Factory::create('App\Category');
        $fullEndpoint= $this->getFullEndpoint($receipt, $category);
        $endpoint = $this->getEndpointWithToken($fullEndpoint);
        $this->call('POST', $endpoint);

        $this->assertTrue($receipt->hasCategory($category));

    }
    /**
     * Remove category from receipt test
     *
     */
    public function testRemoveCategoryReceipt()
    {
        $receipt = Factory::create('App\Receipt');
        $category = Factory::create('App\Category');

        $receipt->categories()->attach($category->id);
        $this->assertTrue($receipt->hasCategory($category));

        $fullEndpoint= $this->getFullEndpoint($receipt, $category);
        $endpoint = $this->getEndpointWithToken($fullEndpoint);
        $this->call('DELETE', $endpoint);
        //fetch receipt again and check categories
        $receipt=\App\Receipt::find($receipt->id);
        $this->assertFalse($receipt->hasCategory($category));


    }

    /**
     * @param $receipt
     * @param $category
     * @return string
     */
    public function getFullEndpoint($receipt, $category)
    {
        return $this->endpoint . '/' . $receipt->id . '/categories/' . $category->id;
    }

    public function getEndpointWithToken($endpoint){
        return $endpoint.'?token='.$this->token;
    }
}
