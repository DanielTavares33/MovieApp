<?php

namespace App\ViewModels;

use Spatie\ViewModels\ViewModel;

class SearchViewModel extends ViewModel
{
    public $searchResults;

    public function __construct($searchResults)
    {
        $this->searchResults = $searchResults;
    }

    public function searchResults() 
    {
        return collect($this->searchResults)->sortByDesc('popularity')->take(7)->map(function($result) {
            
            if (isset($result['title'])) {
                $title = $result['title'];
            } else if (isset($result['name'])) {
                $title = $result['name'];
            } else {
                $title = 'Untitled';
            }

            if (isset($result['poster_path'])) {
                $image = 'https://image.tmdb.org/t/p/w92/' . $result['poster_path'];
            } else if (isset($result['profile_path'])) {
                $image = 'https://image.tmdb.org/t/p/w92/' . $result['profile_path'];
            } else {
                $image = 'https://via.placeholder.com/185x278';
            }

            if (isset($result['media_type'])  === 'movie') {
                $linkToPage = route('movies.show', $result['id']);
            } else if (isset($result['media_type'])  === 'tv') {
                $linkToPage = route('tv.show', $result['id']);
            } else if (isset($result['media_type'])  === 'person') {
                $linkToPage = route('actors.show', $result['id']);
            } else {
                $linkToPage = null;
            }

            return collect($result)->merge([
                'poster_path' => $image,
                'title' => $title,
                'linkToPage' => $linkToPage
            ]);
        });
    }
}
