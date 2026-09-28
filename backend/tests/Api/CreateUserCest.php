<?php

namespace Tests\Api;

use Tests\Support\ApiTester;

class CreateUserCest
{
    public function createUser(ApiTester $I): void
    {
        $request = [
            'email' => 'aqa@example.com',
            'password' => 'Qwerty123!',
        ];

        $I->haveHttpHeader(
            'Content-Type',
            'application/json'
        );

        $I->sendPost(
            '/users',
            $request
        );

        $I->seeResponseCodeIsSuccessful();

        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'email' => $request['email'],
        ]);

        $I->seeResponseMatchesJsonType([
            'id' => 'integer|string',
            'email' => 'string:email',
        ]);
    }
}