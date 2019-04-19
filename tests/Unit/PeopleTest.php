<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Resources\PeopleResource;

class PeopleTest extends TestCase
{
 	protected function setUp()
    {
        /**
         * This disables the exception handling to display the stacktrace on the console
         * the same way as it shown on the browser
         */
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    
    public function test_can_store_people_record() {
	    $people ='[{"first_name":"cody","last_name":"duder","age":38,"email":"codyduder@causelabs.com","secret":"VXNlIHRoaXMgc2VjcmV0IHBocmFzZSBzb21ld2hlcmUgaW4geW91ciBjb2RlJ3MgY29tbWVudHM="},{"first_name":"ladee","last_name":"linter","age":99,"email":"lindaladee@causelabs.com","secret":"cmVzb3VyY2UgdmlvbGF0aW9u"}]' ;
	
		$jsonPeople = json_decode($people);
		
		$response = $this->json('POST', '/people', ['data'=>$jsonPeople]);
		$response
            ->assertStatus(200)
            ->assertJson([
                'email_addresses' => '{"data":"codyduder@causelabs.com,lindaladee@causelabs.com"}',
            ]);
          
        $json = $response->json();
				
	}
}
