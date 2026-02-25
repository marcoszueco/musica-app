<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\User;
use Illuminate\Database\Seeder;

class AlbumSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create([
            'name'     => 'Usuario Demo',
            'email'    => 'demo@musica.com',
            'password' => bcrypt('password'),
        ]);

        $albums = [
            ['title' => 'Thriller',               'artist' => 'Michael Jackson', 'genre' => 'Pop',        'release_year' => 1982, 'average_rating' => 4.8],
            ['title' => 'Dark Side of the Moon',  'artist' => 'Pink Floyd',      'genre' => 'Rock',       'release_year' => 1973, 'average_rating' => 4.9],
            ['title' => 'Kind of Blue',            'artist' => 'Miles Davis',     'genre' => 'Jazz',       'release_year' => 1959, 'average_rating' => 4.7],
            ['title' => 'Nevermind',               'artist' => 'Nirvana',         'genre' => 'Rock',       'release_year' => 1991, 'average_rating' => 4.6],
            ['title' => 'Random Access Memories',  'artist' => 'Daft Punk',       'genre' => 'Electrónica','release_year' => 2013, 'average_rating' => 4.5],
            ['title' => 'Back in Black',           'artist' => 'AC/DC',           'genre' => 'Rock',       'release_year' => 1980, 'average_rating' => 4.7],
            ['title' => 'Rumours',                 'artist' => 'Fleetwood Mac',   'genre' => 'Pop',        'release_year' => 1977, 'average_rating' => 4.6],
            ['title' => 'Abbey Road',              'artist' => 'The Beatles',     'genre' => 'Pop',        'release_year' => 1969, 'average_rating' => 4.9],
            ['title' => 'To Pimp a Butterfly',     'artist' => 'Kendrick Lamar',  'genre' => 'Hip-Hop',   'release_year' => 2015, 'average_rating' => 4.8],
            ['title' => 'Homogenic',               'artist' => 'Björk',           'genre' => 'Electrónica','release_year' => 1997, 'average_rating' => 4.4],
        ];

        foreach ($albums as $data) {
            Album::create(array_merge($data, ['user_id' => $user->id]));
        }
    }
}
