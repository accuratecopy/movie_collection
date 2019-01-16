<?php
/**
 * Created by PhpStorm.
 * User: wilder14
 * Date: 16/01/19
 * Time: 11:36
 */

namespace App\Service;

use GuzzleHttp;

class MovieLister
{
    const API_KEY = '97cf4d88a44535593e484e35ebfd342f';

    public function listPopularMovies()
    {
        $client = new GuzzleHttp\Client();
        $request = $client->request('GET', 'https://api.themoviedb.org/3/movie/popular?api_key=' . self::API_KEY . '&language=fr-FR&region=FR');
        $popularMovies = json_decode($request->getBody(), true)['results'];

        return $popularMovies;
    }
}