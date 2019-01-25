<?php
/**
 * Created by PhpStorm.
 * User: wilder14
 * Date: 25/01/19
 * Time: 11:18
 */

namespace App\Service;

use GuzzleHttp;

class TVShowLister
{
    const API_KEY = '97cf4d88a44535593e484e35ebfd342f';
    const BASE_URI_MOVIE = 'https://api.themoviedb.org/3/tv/';
    const LANGUAGE_REGION = '&language=fr-FR&region=FR';

    public function listPopularTVShows()
    {
        $client = new GuzzleHttp\Client();
        $request = $client->request('GET', self::BASE_URI_MOVIE . 'popular?api_key=' . self::API_KEY . self::LANGUAGE_REGION);
        $popularTVShows = json_decode($request->getBody(), true)['results'];

        return $popularTVShows;
    }

    public function listOneTVShowById(int $tvShowId)
    {
        $client = new GuzzleHttp\Client();
        $request = $client->request('GET', self::BASE_URI_MOVIE . $tvShowId . '?api_key=' . self::API_KEY . '&append_to_response=videos,images' . self::LANGUAGE_REGION);
        $tvShowDetails = json_decode($request->getBody(), true);

        return $tvShowDetails;
    }

    public function listTVShow(int $tvShowId)
    {
        $client = new GuzzleHttp\Client();
        $request = $client->request('GET', self::BASE_URI_MOVIE . $tvShowId . '?api_key=' . self::API_KEY . self::LANGUAGE_REGION);
        $json = json_decode($request->getBody());

        return $json;
    }

    public function listTVShowByTitle(string $tvShowTitle)
    {
        $client = new GuzzleHttp\Client();
        $request = $client->request('GET', 'https://api.themoviedb.org/3/search/tv/?api_key=' . self::API_KEY . self::LANGUAGE_REGION . '&query=' . $tvShowTitle);
        $tvShowDetails = json_decode($request->getBody(), true);

        return $tvShowDetails;
    }
}