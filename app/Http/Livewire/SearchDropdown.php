<?php

namespace App\Http\Livewire;

use App\ViewModels\SearchViewModel;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class SearchDropdown extends Component
{
    public $search = '';

    public function render()
    {
        $searchResults = [];

        if (strlen($this->search) >= 2) {
            $movies = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/search/movie?query=' . $this->search)
            ->json()['results'];

            $tvshows = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/search/tv?query=' . $this->search)
            ->json()['results'];

            $searchResults = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/search/multi?query=' . $this->search)
            ->json()['results'];
            // dd($searchResults);
        }

        $viewModel = new SearchViewModel($searchResults);
       
        return view('livewire.search-dropdown', $viewModel);
        // return view('livewire.search-dropdown', [
        //     'searchResults' => collect($searchResults)->take(7)
        // ]);
    }
}
