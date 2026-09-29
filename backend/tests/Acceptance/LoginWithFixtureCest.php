<?php

declare(strict_types=1);

namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Tests\Support\Page\Acceptance\LoginPage;

class LoginWithFixtureCest
{
    private array $user;

    public function _before(AcceptanceTester $I): void
    {
        $this->user = $I->createTestUserDirectlyInDb();

        $I->amOnPage(LoginPage::URL);
    }

    public function loginWithPreparedUser(AcceptanceTester $I): void
    {
        $I->fillField(
            LoginPage::LOGIN_INPUT,
            $this->user['email']
        );

        $I->fillField(
            LoginPage::PASSWORD_INPUT,
            'Qwerty123!'
        );

        $I->click(LoginPage::SUBMIT_BUTTON);

        $I->seeCurrentUrlEquals('/dashboard');
    }
}