@extends('layouts.main')

@section('content')
  <div class="movie-info border-b border-gray-800">
    <div class="container mx-auto px-4 py-16 flex flex-col md:flex-row">
      <div class="flex-none">
        <img src="{{ $movie['poster_path'] }}" alt="parasite" class="w-64 md:w-96">        
      </div>
      <div class="md:ml-24">
        <h2 class="text-4xl font-semibold">{{ $movie['original_title'] }}</h2>
        <div class="flex flex-wrap items-center text-gray-400 text-sm mt-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="fill-current text-orange-500 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
          </svg>
          <span class="ml-1">{{ $movie['vote_average'] }}</span>
          <span class="mx-2">|</span>
          <span>{{ $movie['release_date'] }}</span>
          <span class="mx-2">|</span>
          <span>
            {{ $movie['genres'] }}
          </span>
        </div>
        <p class="text-gray-300 mt-8">{{ $movie['overview'] }}</p>
        <div class="mt-12">
          <h4 class="text-white font-semibold">Featured Cast</h4>
          <div class="flex mt-4">
            @foreach ($movie['crew'] as $crew)
              <div class="mr-8">
                <div>{{ $crew['name'] }}</div>
                <div class="text-sm text-gray-400">{{ $crew['job'] }}</div>
              </div>
            @endforeach
          </div>
          <div x-data="{ isOpen: false }">
            @if (count($movie['videos']['results']) > 0)
            <div class="mt-12" @click.away="isOpen = false">
              <button @click="isOpen = true" class="inline-flex item-center bg-orange-500 text-gray-900 rounded font-semibold px-5 py-4 hover:bg-orange-600 transition ease-in-out duration-150">
                <svg class="w-6 fill-current" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><path d="M10 16.5l6-4.5-6-4.5v9zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
                <span class="ml-2">Play Trailer</span>
              </button>
            </div>
            {{-- MODAL TO SHOW TRAILER --}}
            <div class="fixed top-0 left-0 w-full h-full flex items-center shadow-lg overflow-y-auto" style="background-color: rgb(0, 0, 0, .5);" x-show.transition.opacity="isOpen">
              <div class="container mx-auto lg:px-32 rounded-lg overflow-y-auto">
                <div class="bg-gray-900 rounded">
                  <div class="flex justify-end pr-4 pt-2">
                    <button class="text-3xl leading-none hover:text-gray-300" @click="isOpen = false">&times;</button>
                  </div>
                  <div class="modal-body px-8 py-8">
                    <div class="responsive-container overflow-hidden relative" style="padding-top: 56.25%">
                      <iframe width="560" height="315" class="responsive-iframe absolute top-0 left-0 w-full h-full" src="https://youtube.com/embed/{{ $movie['videos']['results'][0]['key'] }}" frameborder="0" style="border: 0;" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="movie-cast border-b border-gray-800"> {{-- start movie-cast --}}
    <div class="container mx-auto px-4 py-16">
      <h2 class="text-4xl font-semibold">Cast</h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
        @foreach ($movie['cast'] as $cast)
          <div class="mt-8">
            <a href="#">
              <img src="{{ 'https://image.tmdb.org/t/p/w500/' . $cast['profile_path'] }}" alt="actor1" class="hover:opacity-75 transition ease-in-out duration-150">
            </a>
            <div class="mt-2">
              <a href="" class="text-lg mt-2 hover:text-gray-300">{{ $cast['character'] }}</a>
              <div class="text-gray-400 text-sm">
                {{ $cast['original_name'] }}
              </div>
            </div>
          </div>
        @endforeach
      </div>
  </div> {{-- end movie-cast --}}
  <div class="movie-images border-b border-gray-800" x-data="{ isOpen: false, image: ''}"> {{-- start movie-images --}}
    <div class="container mx-auto px-4 py-16">
      <h2 class="text-4xl font-semibold">Images</h2>
      <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach ($movie['images'] as $image)
          <div class="mt-8">
            <a href="#" @click.prevent="isOpen=true, image='{{ 'https://image.tmdb.org/t/p/original/' . $image['file_path'] }}'">
              <img src="{{ 'https://image.tmdb.org/t/p/w500/' . $image['file_path'] }}" alt="image1" class="hover:opacity-75 transition ease-in-out duration-150">
            </a>
          </div>
        @endforeach
      </div>
      {{-- MODAL FOR IMAGES --}}
      <div class="fixed top-0 left-0 w-full h-full flex items-center shadow-lg overflow-y-auto" style="background-color: rgb(0, 0, 0, .5);" x-show.transition.opacity="isOpen">
        <div class="container mx-auto lg:px-32 rounded-lg overflow-y-auto" @click.away="isOpen = false">
          <div class="bg-gray-900 rounded">
            <div class="flex justify-end pr-4 pt-2">
              <button class="text-3xl leading-none hover:text-gray-300" @click="isOpen = false" @keydown.escape.window="isOpen = false">&times;</button>
            </div>
            <div class="modal-body px-8 py-8">
              <img :src="image" alt="poster">
            </div>
          </div>
        </div>
      </div>
  </div>{{-- end movie-images --}}
@endsection