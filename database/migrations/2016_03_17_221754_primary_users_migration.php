<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PrimaryUsersMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('users')->insert([
            ['first_name' => 'Jon',     'last_name' => 'Robinson',      'email' => 'jon.f.robinson@gmail.com',      'password' => Hash::make('DerayOnTheRise'),     'facebook_id' => '10102658699441805',   'respondant' => false,      'created_at' => Carbon::now()->toDateTimeString(),      'updated_at' => Carbon::now()->toDateTimeString()],
            ['first_name' => 'Rob',     'last_name' => 'Preston',       'email' => 'robmpreston@gmail.com',         'password' => Hash::make('DerayOnTheRise'),     'facebook_id' => null,                  'respondant' => false,      'created_at' => Carbon::now()->toDateTimeString(),      'updated_at' => Carbon::now()->toDateTimeString()],
            ['first_name' => 'Derek',   'last_name' => 'Torsoni',       'email' => 'derektorsani@gmail.com ',       'password' => Hash::make('DerayOnTheRise'),     'facebook_id' => null,                  'respondant' => false,      'created_at' => Carbon::now()->toDateTimeString(),      'updated_at' => Carbon::now()->toDateTimeString()],
            ['first_name' => 'John',    'last_name' => 'Sparwasser',    'email' => 'johnspar1@gmail.com',           'password' => Hash::make('DerayOnTheRise'),     'facebook_id' => null,                  'respondant' => false,      'created_at' => Carbon::now()->toDateTimeString(),      'updated_at' => Carbon::now()->toDateTimeString()],

            // Respondants
            ['first_name' => 'Deray',   'last_name' => 'Mckesson',      'email' => 'deray@derayformayor.com',       'password' => Hash::make('DerayOnTheRise'),     'facebook_id' => null,                  'respondant' => true,       'created_at' => Carbon::now()->toDateTimeString(),      'updated_at' => Carbon::now()->toDateTimeString()], // user_id = 5
        ]);

        DB::table('profiles')->insert([
            [   // DERAY MCKESSON
                'user_id' => 5, 
                'slug' => 'derek-mckesson',
                'i_am_a' => 'Baltimore Mayoral Candidate',
                'from' => 'Baltimore, MD', 
                'description' => 'I am running to be the 50th Mayor of Baltimore in order to usher our city into an era where the government is accountable to its people and is aggressively innovative in how it identifies and solves its problems. We can build a Baltimore where more and more people want to live and work, and where everyone can thrive.',
                'website_url' => 'https://www.derayformayor.com',
                'facebook_url' => 'https://www.facebook.com/derayformayor',
                'twitter_url' => 'https://twitter.com/deray',
                'created_at' => Carbon::now()->toDateTimeString(),      
                'updated_at' => Carbon::now()->toDateTimeString(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('users')->truncate();
        DB::table('profiles')->truncate();
    }
}
