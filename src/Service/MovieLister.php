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
    const BASE_URI_MOVIE = 'https://api.themoviedb.org/3/movie/';
    const LANGUAGE_REGION = '&language=fr-FR&region=FR';

    public function listPopularMovies()
    {
        $client = new GuzzleHttp\Client();
        $request = $client->request('GET', self::BASE_URI_MOVIE . 'popular?api_key=' . self::API_KEY . self::LANGUAGE_REGION);
        $popularMovies = json_decode($request->getBody(), true)['results'];

        return $popularMovies;
    }

    public function listOneMovieById(int $movieId)
    {
        $client = new GuzzleHttp\Client();
        $request = $client->request('GET', self::BASE_URI_MOVIE . $movieId . '?api_key=' . self::API_KEY . '&append_to_response=videos,images' . self::LANGUAGE_REGION);
        $movieDetails = json_decode($request->getBody(), true);

        return $movieDetails;
    }

    public function listMovieCastById(int $movieId)
    {
        $client = new GuzzleHttp\Client();
        $request = $client->request('GET', self::BASE_URI_MOVIE . $movieId . '/credits?api_key=' . self::API_KEY . '&append_to_response=videos,images' . self::LANGUAGE_REGION);
        $movieCasts = json_decode($request->getBody(), true);

        return $movieCasts;
    }

    public function listMovie(int $movieId)
    {
        $client = new GuzzleHttp\Client();
        $request = $client->request('GET', self::BASE_URI_MOVIE . $movieId . '?api_key=' . self::API_KEY . self::LANGUAGE_REGION);
        $json = json_decode($request->getBody());

        return $json;
    }

    public function listMovieByTitle(string $movieTitle)
    {
        $client = new GuzzleHttp\Client();
        $request = $client->request('GET', 'https://api.themoviedb.org/3/search/movie/?api_key=' . self::API_KEY . self::LANGUAGE_REGION . '&query=' . $movieTitle);
        $movieDetails = json_decode($request->getBody(), true);

        return $movieDetails;
    }
}