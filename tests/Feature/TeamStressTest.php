<?php

use function Pest\Stressless\stress;

it('has a fast response time', function () {
    // Send a request to get the CSRF cookie
    $response = $this->get('/api/v1/sanctum/csrf-cookie');

    // Extract the cookies from the response
    $cookies = $response->headers->getCookies();
    dd($cookies);
    $result = stress(route('teams.index'))
    ->headers([
        ''
    ]);


    expect($result->requests()->duration()->med())->toBeLessThan(500);
});