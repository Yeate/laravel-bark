<?php

use Illuminate\Support\Facades\Route;

Route::any('/ping', 'BarkPushController@ping');
Route::any('/register', 'BarkPushController@register');

Route::any('bark/push','BarkPushController@push');


