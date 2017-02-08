<?php

// List all resources available in scraper
Route::get('', [
  'as' => 'sources.index',
  'uses' => 'SourceController@index'
]);

// Scrape all sources
Route::get('scrape', [
  'as' => 'sources.all.scrape',
  'uses' => 'SourceController@ascrape'
]);

// Display source informaiton
Route::get('{sourceName}', [
  'as' => 'sources.show',
  'uses' => 'SourceController@show'
]);

// Scrape a source
Route::get('{sourceName}/scrape', [
  'as' => 'sources.scrape',
  'uses' => 'SourceController@scrape'
]);
