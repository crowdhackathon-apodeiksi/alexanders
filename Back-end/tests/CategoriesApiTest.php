<?php

use App\Category;

class CategoriesApiTest extends TestCase {
    protected $endpoint;
    protected $faker;
    protected $token;

    function __construct()
    {
        $this->endpoint='/api/me/categories';
        $this->faker= Faker\Factory::create();
        $this->token="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXUyJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6XC9cL2hvbWVzdGVhZC5hcHA6ODAwMFwvand0XC9jcmVhdGUiLCJpYXQiOiIxNDM0MjA5NDI3IiwiZXhwIjoiMTQzNDIxMzAyNyIsIm5iZiI6IjE0MzQyMDk0MjciLCJqdGkiOiJlMTMzZTg4MmI2NDkyZWMyMTU4OTZhNDY4OGMyMDYyYiJ9.ZWUzMGI5MTBjMzUwNGRiYmMzZjE2YjFkNTE3ZTZlZWU5Yzg0OTU4ZTlhYzM1MzBhYWE3OTA1MzhkNjI0NzhlMg";
    }
    /*
     * Index Categories test
     * */
    public function testIndexCategories(){
        $endpoint = $this->getEndpointWithToken($this->endpoint);
        $response = $this->call('GET', $endpoint);


        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
	 * Category Create test
	 *
	 * @return void
	 */
	public function testCreateCategory()
	{
        $category=[
            'name' => $this->faker->word.'999'
        ];

        $endpoint = $this->getEndpointWithToken($this->endpoint);
        $this->call('POST', $endpoint, $category);
        //fetch inserted category
        $inserted_category=Category::whereName($category['name'])->first();
		$this->assertInstanceOf('App\Category', $inserted_category);
	}

    /**
	 * Category Update test
	 *
	 * @return void
	 */
	public function testUpdateCategory()
	{
        $category=Category::first();
        $toUpdate=['name'=>$this->faker->word.'777'];

        $endpoint = $this->getEndpointWithToken($this->endpoint.'/'.$category->id);
        $this->call('PATCH', $endpoint, $toUpdate);
        //fetch inserted category
        $updated_category=Category::whereId($category->id)->first();
		$this->assertEquals($toUpdate['name'], $updated_category->name);
	}
    /**
	 * Category DELETE test
	 *
	 * @return void
	 */
	public function testDELETECategory()
	{
        $category=Category::first();

        $endpoint = $this->getEndpointWithToken($this->endpoint.'/'.$category->id);
        $this->call('DELETE', $endpoint);
        //fetch inserted category
        $deleted_category=Category::find($category->id);
		$this->assertNull($deleted_category);
	}

    public function getEndpointWithToken($endpoint){
        return $endpoint.'?token='.$this->token;
    }
}
