<?php

use Illuminate\Database\Seeder;

class BeginingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'level' => 'admin',
            'password' => Hash::make('12345678'),
        ]);

        factory(App\User::class, 9)->create([
            'password' => Hash::make('12345678')
        ]);

        factory(App\Author::class, 10)->create();

        factory(App\Book::class, 10)->create();

        $author = App\Author::all();

        App\Book::all()->each(function ($book) use ($author) { 
            $book->author()->attach(
                $author->random(rand(1, 3))->pluck('id')->toArray()
            ); 
        });
        
    }
}