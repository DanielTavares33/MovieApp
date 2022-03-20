<?php

namespace App\ViewModels;

use Spatie\ViewModels\ViewModel;

class ActorsViewModel extends ViewModel
{
    public $popularActors;
    public $page;

    public function __construct($popularActors, $page)
    {
        $this->popularActors = $popularActors;
        $this->page = $page;
    }

    public function popularActors()
    {
        return collect($this->popularActors)->map(function($actor) {

            // merge the data that we want from the request to the request and return only the fields used
            return collect($actor)->merge([
                'profile_path' => $actor['profile_path'] ? 
                'https://image.tmdb.org/t/p/w470_and_h470_face' . $actor['profile_path'] : 
                'https://ui-avatars.com/api/?size=470&name=' . $actor['name'],
                'known_for' => collect($actor['known_for'])->where('media_type', 'movie')->pluck('title')->union(
                    collect($actor['known_for'])->where('media_type', 'tv')->pluck('name')
                )->implode(', ')
            ])->only([
                'name', 'id', 'profile_path', 'known_for'
            ])->dump();
        });
    }

    public function previous()
    {
        return $this->page > 1 ? $this->page - 1 : null;
    }

    public function next()
    {
        return $this->page < 500 ? $this->page + 1 : null;
    }
}