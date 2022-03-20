<?php

namespace App\ViewModels;

use Spatie\ViewModels\ViewModel;

class ActorViewModel extends ViewModel
{
    public $actor;

    public function __construct($actor)
    {
        $this->actor = $actor;
    }

    public function actor()
    {
        return collect($this->actor)->dump();
        // return collect($this->actor)->map(function($value) {
        //     // merge the data that we want from the request to the request and return only the fields used
        //     return collect($value)->merge([
        //         'profile_path' => $value['profile_path'] ? 
        //         'https://image.tmdb.org/t/p/w470_and_h470_face' . $value['profile_path'] : 
        //         'https://ui-avatars.com/api/?size=470&name=' . $value['name'],
        //         'popularity' =>  
        //     ])->only([
        //         'name', 'id', 'profile_path', 'known_for'
        //     ]);
        // });
    }
}
