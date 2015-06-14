<?php

use App\Receipt;

class ReceiptsApiTest extends TestCase {
    protected $endpoint;
    protected $faker;
    protected $token;

    function __construct()
    {
        $this->endpoint='api/me/receipts';
        $this->faker= Faker\Factory::create();
        $this->token="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXUyJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6XC9cL2hvbWVzdGVhZC5hcHA6ODAwMFwvand0XC9jcmVhdGUiLCJpYXQiOiIxNDM0MjA5NDI3IiwiZXhwIjoiMTQzNDIxMzAyNyIsIm5iZiI6IjE0MzQyMDk0MjciLCJqdGkiOiJlMTMzZTg4MmI2NDkyZWMyMTU4OTZhNDY4OGMyMDYyYiJ9.ZWUzMGI5MTBjMzUwNGRiYmMzZjE2YjFkNTE3ZTZlZWU5Yzg0OTU4ZTlhYzM1MzBhYWE3OTA1MzhkNjI0NzhlMg";
    }
    /*
     * Index Receipts test
     * */
    public function testIndexReceipts(){
        $endpoint = $this->getEndpointWithToken($this->endpoint);
        $response = $this->call('GET', $endpoint);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
	 * Receipt Create test
	 *
	 * @return void
	 */
	public function testCreateReceipt()
	{
        $receipt=[
            'aa' => $this->faker->numberBetween(10000, 1000000),
            'afm' => $this->faker->numberBetween(100000000, 999999999),
            'eponimia' => $this->faker->name,
            'poso' => $this->faker->randomFloat(2, 1, 5000),
            'image' => $this->faker->imageUrl(),
            'printed_at' => 1433794593
        ];

        $endpoint = $this->getEndpointWithToken($this->endpoint);
        $this->call('POST', $endpoint, $receipt);
        //fetch inserted receipt
        $inserted_receipt=Receipt::whereAfm($receipt['afm'])->whereAa($receipt['aa'])->first();
		$this->assertInstanceOf('App\Receipt', $inserted_receipt);
	}

    /**
	 * Receipt Update test
	 *
	 * @return void
	 */
	public function testUpdateReceipt()
	{
        $receipt=Receipt::first();
        $toUpdate=['eponimia'=>$this->faker->word.'777'];
        $endpoint = $this->getEndpointWithToken($this->endpoint.'/'.$receipt->id);
        $this->call('PATCH', $endpoint, $toUpdate);
        //fetch inserted receipt
        $updated_receipt=Receipt::whereId($receipt->id)->first();
		$this->assertEquals($toUpdate['eponimia'], $updated_receipt->eponimia);
	}
    /**
	 * Receipt DELETE test
	 *
	 * @return void
	 */
	public function testDELETEReceipt()
	{
        $receipt=Receipt::first();
        $endpoint = $this->getEndpointWithToken($this->endpoint.'/'.$receipt->id);
        $this->call('DELETE', $endpoint);
        //fetch inserted receipt
        $deleted_receipt=Receipt::find($receipt->id);
		$this->assertNull($deleted_receipt);
	}

    public function getEndpointWithToken($endpoint){
        return $endpoint.'?token='.$this->token;
    }

}
