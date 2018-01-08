<?php
/**
 * Unauthenticated routes
 */

Auth::routes();

Route::get('/', 'SingleInvokes\WelcomeController');
