<?php

namespace App\ViewModels;

use Carbon\Carbon;
use Spatie\ViewModels\ViewModel;

class TvShowsViewModel extends ViewModel
{
    public $populaTV;
    public $topRatedTv;
    public $genres;

    public function __construct($populaTV, $topRatedTv, $genres)
    {
        $this->populaTV = $populaTV;
        $this->topRatedTv = $topRatedTv;
        $this->genres = $genres;
    }

    public function popularTV() 
    {
        return $this->formattvshowss($this->populaTV);
    }

    public function topRatedTv() 
    {
        return $this->formattvshowss($this->topRatedTv);
    }

    public function genres() 
    {
        return collect($this->genres)->mapWithKeys(function ($genre) {
            return [$genre['id'] => $genre['name']];
        });
    }

    private function formattvshowss($tv)
    {
        return collect($tv)->map(function($tvshows) {

            $genresFormated = collect($tvshows['genre_ids'])->mapWithKeys(function($value) {
                return [$value => $this->genres()->get($value)];
            })->implode(', ');

            // merge the data that we want from the request to the request and return only the fields used
            return collect($tvshows)->merge([
                'poster_path' => $tvshows['poster_path'] ? 'https://image.tmdb.org/t/p/w500' . $tvshows['poster_path'] : ' https://dummyimage.com/500x750/ffffff/000000.png',
                'vote_average' => $tvshows['vote_average'] * 10 . '%',
                'first_air_date' => Carbon::parse($tvshows['first_air_date'])->format('M d, Y'),
                'genres' => $genresFormated
            ])->only([
                'poster_path', 'id', 'genre_ids', 'name', 'vote_average', 'overview', 'first_air_date', 'genres'
            ]);
        });
    }
}
