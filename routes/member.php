<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'member',
    'middleware' => 'role:member',
    'as' => 'member.'
], function () {

    Route::get('/', function () {
        return redirect()->route('member.user.index');
    });

});
