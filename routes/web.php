<?php

use Illuminate\Support\Facades\Route;

Route::get('/ping', 'BarkPushController@ping');
Route::get('/register', 'BarkPushController@register');

Route::get('bark/push','BarkPushController@push');


