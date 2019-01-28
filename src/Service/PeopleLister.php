<?php
/**
 * Created by PhpStorm.
 * User: wilder14
 * Date: 28/01/19
 * Time: 09:52
 */

namespace App\Service;

use GuzzleHttp;

class PeopleLister
{
    const API_KEY = '97cf4d88a44535593e484e35ebfd342f';
    const BASE_URI_MOVIE = 'https://api.themoviedb.org/3/person/';
    const LANGUAGE_REGION = '&language=fr-FR&region=FR';

    public function listPopularPeople()
    {
        $client = new GuzzleHttp\Client();
        $request = $client->request('GET', self::BASE_URI_MOVIE . 'popular?api_key=' . self::API_KEY . self::LANGUAGE_REGION);
        $popularPeople = json_decode($request->getBody(), true)['results'];

        return $popularPeople;
    }

    public function listOnePeopleById(int $peopleId)
    {
        $client = new GuzzleHttp\Client();
        $request = $client->request('GET', self::BASE_URI_MOVIE . $peopleId . '?api_key=' . self::API_KEY . '&append_to_response=videos,images' . self::LANGUAGE_REGION);
        $peopleDetails = json_decode($request->getBody(), true);

        return $peopleDetails;
    }

    public function listMovieCreditsById(int $peopleId)
    {
        $client = new GuzzleHttp\Client();
        $request = $client->request('GET', self::BASE_URI_MOVIE . $peopleId . '/movie_credits' . '?api_key=' . self::API_KEY . '&append_to_response=videos,images' . self::LANGUAGE_REGION);
        $peopleMovieCredits = json_decode($request->getBody(), true);

        return $peopleMovieCredits;
    }

    public function listPeople(int $peopleId)
    {
        $client = new GuzzleHttp\Client();
        $request = $client->request('GET', self::BASE_URI_MOVIE . $peopleId . '?api_key=' . self::API_KEY . self::LANGUAGE_REGION);
        $json = json_decode($request->getBody());

        return $json;
    }

    public function listPeopleByName(string $peopleName)
    {
        $client = new GuzzleHttp\Client();
        $request = $client->request('GET', 'https://api.themoviedb.org/3/search/movie/?api_key=' . self::API_KEY . self::LANGUAGE_REGION . '&query=' . $peopleName);
        $peopleDetails = json_decode($request->getBody(), true);

        return $peopleDetails;
    }
}