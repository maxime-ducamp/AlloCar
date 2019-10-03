<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes();
Route::get('inscription', 'Auth\RegisterController@showRegistrationForm')->name('inscription');
Route::get('connection', 'Auth\LoginController@showLoginForm')->name('connection');

Route::middleware('auth')->group(function() {

    /** Journeys | Requires Authentication */
    Route::get('trajets/nouveau', 'JourneysController@create')->name('journeys.create');
    Route::get('trajets/{journey}/modifier', 'JourneysController@edit')->name('journeys.edit');
    Route::post('trajets/{journey}/complete', 'JourneysController@complete')->name('journeys.complete');
    Route::post('trajets', 'JourneysController@store')->name('journeys.store');
    Route::put('trajets/{journey}', 'JourneysController@update')->name('journeys.update');
    Route::delete('trajets/{journey}', 'JourneysController@destroy')->name('journeys.destroy');

    /** Comments | Requires Authentication */
    Route::post('trajets/{journey}/commentaires', 'CommentsController@store')->name('comments.store');
    Route::get('trajets/{journey}/commentaires/{comment}/modifier', 'CommentsController@edit')->name('comments.edit');
    Route::put('trajets/{journey}/commentaires/{comment}', 'CommentsController@update')->name('comments.update');
    Route::delete('/trajets/{journey}/commentaires/{comment}/supprimer', 'CommentsController@destroy')->name('comments.destroy');

    /** Bookings | Requires Authentication*/
    Route::post('trajets/{journey}/reservations', 'BookingsController@store')->name('bookings.store');
    Route::post('trajets/{journey}/reservations/{booking}/accepter', 'BookingsController@approve')->name('bookings.approve');
    Route::post('trajets/{journey}/reservations/{booking}/refuser', 'BookingsController@deny')->name('bookings.deny');

    /** Private Messages | Requires Authentication */
    Route::get('utilisateurs/{user}/messages', 'PrivateMessagesController@index')->name('private-messages.index');
    Route::get('utilisateurs/{user}/messages/{private_message}/repondre', 'PrivateMessagesController@answer')->name('private-messages.answer');
    Route::post('utilisateurs/{user}/messages/{private_message}/repondre', 'PrivateMessagesController@storeAnswer')->name('private-messages.storeAnswer');
    Route::post('utilisateurs/{user}/messages/{private_message}/marquer-comme-lu', 'PrivateMessagesController@markAsRead')->name('private-messages.markAsRead');
    Route::post('utilisateurs/{user}/messages', 'PrivateMessagesController@sendMessage')->name('private-messages.store');

    /** Notifications | Requires Authentication */
    Route::post('utilisateurs/{user}/notifications/{notification_id}', 'NotificationsController@destroy')->name('notifications.destroy');


    /** Users | Requires Authentication*/
    Route::put('utilisateurs/{user}', 'UsersController@update')->name('users.update');
    Route::get('utilisateurs/{user}/supprimer-mon-compte', 'UsersController@showDeleteAccountForm')->name('users.delete-form');
    Route::post('utilisateurs/{user}/destroy', 'UsersController@destroy')->name('users.destroy');

});

/** Journeys search | Guest */
Route::get('trajets/rechercher', 'JourneySearchController@index')->name('journeys.search.index');
Route::post('trajets/rechercher', 'JourneySearchController@show')->name('journeys.search.show');

/** Journeys | Guest */
Route::get('/', 'JourneysController@index')->name('index');
Route::get('trajets/{journey}', 'JourneysController@show')->name('journeys.show');

/** User Profiles | Guest */
Route::get('utilisateurs/{user}', 'ProfilesController@index')->name('profiles.index');
Route::get('utilisateurs/{user}/trajets', 'ProfilesController@journeys')->name('profiles.journeys');
Route::get('utilisateurs/{user}/reservations', 'ProfilesController@bookings')->name('profiles.bookings');

/** Miscellaneous | Guest */
Route::get('foire-aux-questions','BaseController@frequentlyAskedQuestions')->name('faq');
Route::get('/mentions-legales', 'BaseController@legalMentions')->name('legal-mentions');
Route::get('/contactez-nous', 'BaseController@contact')->name('contact');

/** Admin */
Route::middleware('admin')->group(function () {

    Route::get('admin/accueil', 'Admin\AdminController@index')->name('admin.dashboard');

    /** Users */
    Route::get('admin/utilisateurs', 'Admin\AdminUsersController@index')->name('admin.users.index');
    Route::get('admin/utilisateurs/{user}/modifier', 'Admin\AdminUsersController@edit')->name('admin.users.edit');
    Route::put('admin/utilisateurs/{user}', 'Admin\AdminUsersController@update')->name('admin.users.update');
    Route::delete('admin/utilisateurs/{user}', 'Admin\AdminUsersController@destroy')->name('admin.users.destroy');

    /** Comments */
    Route::get('admin/commentaires', 'Admin\AdminCommentsController@index')->name('admin.comments.index');
    Route::get('admin/commentaires/{comment}/modifier', 'Admin\AdminCommentsController@edit')->name('admin.comments.edit');
    Route::put('admin/commentaires/{comment}', 'Admin\AdminCommentsController@update')->name('admin.comments.update');
    Route::delete('admin/commentaires/{comment}', 'Admin\AdminCommentsController@destroy')->name('admin.comments.destroy');

    /** Journeys */
    Route::get('admin/trajets', 'Admin\AdminJourneysController@index')->name('admin.journeys.index');
    Route::get('admin/trajets/{journey}/modifier', 'Admin\AdminJourneysController@edit')->name('admin.journeys.edit');
    Route::put('admin/trajets/{journey}', 'Admin\AdminJourneysController@update')->name('admin.journeys.update');
    Route::delete('admin/trajets/{journey}', 'Admin\AdminJourneysController@destroy')->name('admin.journeys.destroy');
});

Route::middleware('super_admin')->group(function() {

    /** Roles | Requires super_admin role */
    Route::get('admin/roles', 'Admin\AdminRolesController@index')->name('admin.roles.index');
    Route::post('admin/roles', 'Admin\AdminRolesController@store')->name('admin.roles.store');
    Route::post('admin/roles/{user}/assigner-un-role', 'Admin\AdminRolesController@addRole')->name('admin.roles.assign-role');
    Route::post('admin/roles/{user}/retirer-un-role', 'Admin\AdminRolesController@removeRole')->name('admin.roles.remove-role');
});
