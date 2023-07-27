<?php
use Tests\TestCase;
use App\Helpers\TeHelper; // Update the namespace accordingly
use Carbon\Carbon;

class AppTests extends TestCase {

	public function testWillExpireAt() {
		// Test 1: Diff less than or equal to 90 hours
		// Create the first date
		$now = Carbon::now(); // Current date and time
		$due_time = $now->copy()->addHours(80); // Add 80 hours to the current date and time
		$createdAt = $due_time->copy()->subHours(85); // Subtract 85 hours from the due time
		$expected = $due_time->format('Y-m-d H:i:s');
		$result1= TeHelper::willExpireAt($due_time, $createdAt);
		$this->assertEquals($expected, $result1);

		// Test 2: Diff less than or equal to 24 hours
		$now = Carbon::now(); // Current date and time
		$due_time = $now->copy()->addHours(20); // Add 20 hours to the current date and time
		$createdAt = $due_time->copy()->subHours(18); // Subtract 18 hours from the due time
		$expected = $due_time->format('Y-m-d H:i:s');
		$result1= TeHelper::willExpireAt($due_time, $createdAt);
		$this->assertEquals($expected, $result1);

		// Test 3: Diff > 24 hr and <= 72 hr
		$now = Carbon::now(); // Current date and time
		$due_time = $now->copy()->addHours(20); // Add 20 hours to the current date and time
		// second date with a difference of less than or equal to 24 hours from the first date
		$createdAt = $due_time->copy()->subHours(18); // Subtract 22 hours from the due time
		$expected = $createdAt->addHours(16)->format('Y-m-d H:i:s');
		$result = TeHelper::willExpireAt($due_time, $createdAt);
		$this->assertEquals($expected, $result);

		// Test 4: Diff > 72 hr
		$now = Carbon::now(); // Current date and time
		$due_time = $now->copy()->addHours(100); // Add 20 hours to the current date and time
		// second date with a difference greater then 72 hours from the first date
		$createdAt = $due_time->copy()->subHours(120); // Add 20 hours from the due time
		$expected = $createdAt->addHours(48)->format('Y-m-d H:i:s');
		$result = TeHelper::willExpireAt($due_time, $createdAt);
		$this->assertEquals($expected, $result);
	}

	public function testCreateOrUpdateUser()
	{
		$userData = [
			'role' => env('CUSTOMER_ROLE_ID'),
			'name' => 'Sarmad Abbasi',
			'email' => 'sarmad@test.com',
			'dob_or_orgid' => '123456789',
			'phone' => '1234567890',
		];

		$response = $this->postJson('/user/create', $userData);
		$response->assertStatus(200)
		         ->assertJson(['status' => 'success']);

		$user = User::where('email', 'sarmad@test.com')->first();
		$this->assertNotNull($user);
		$this->assertEquals(config('app.CUSTOMER_ROLE_ID'), $user->user_type);
	}


}