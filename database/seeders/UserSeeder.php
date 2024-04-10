<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserSeeder
{
    private $userCount = 15;

    private $keyWords = ['apple', 'art', 'orange', 'pinnaple', 'liver', 'pizza', 'house', 'sky', 'tree', 'sunset', 'sunrise', 'cat', 'dog'];

    public function run()
    {
        $this->generateUsers();
    }

    private function generateUsers()
    {
        $users = [];

        for ($i = 0; $i < $this->userCount; $i++) {
            $randomWord = $this->keyWords[random_int(0, count($this->keyWords) - 1)];
            $randomModified = random_int(1, 5);

            $user = User::factory()->state([
                'picture' => "https://source.unsplash.com/random?$randomWord&$randomModified"
            ])->make()->toArray();

            $user['email_verified_at'] = Carbon::now()->toDateTimeString();

            $users[] = $user;
        }

        DB::table('users')->insert($users);
    }
}
