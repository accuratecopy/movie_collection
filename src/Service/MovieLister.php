<?php
/**
 * Created by PhpStorm.
 * User: wilder14
 * Date: 16/01/19
 * Time: 11:36
 */

namespace App\Service;

use GuzzleHttp;
use GuzzleHttp\Exception\GuzzleException;

class MovieLister
{
    const API_KEY = '97cf4d88a44535593e484e35ebfd342f';

    public function listLastMoviesAdded()
    {
        $client = new GuzzleHttp\Client();
        try {
            $request = $client->request('GET', 'https://api.themoviedb.org/3/search/movie/lastest?api_key=' . self::API_KEY . '&language=fr-FR&region=FR');
        } catch (GuzzleException $e) {
        }
        $lastMovies = json_decode($request->getBody(), true);

        return $lastMovies;
    }
}