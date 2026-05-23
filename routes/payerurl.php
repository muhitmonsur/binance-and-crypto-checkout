<?php

use Illuminate\Support\Facades\Route;
use Payerurl\Http\Controllers\NotifyController;

Route::group(['prefix' => config('payerurl.route.prefix', 'payerurl'), 'middleware' => config('payerurl.route.middleware', []),], function () {
    Route::post('notify', [NotifyController::class, 'payerurlCallback'])->name('payerurl.notify');
});
