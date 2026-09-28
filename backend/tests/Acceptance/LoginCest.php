<?php

declare(strict_types=1);

namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Tests\Support\Page\Acceptance\LoginPage;

final class LoginCest
{
    public function _before(AcceptanceTester $I): void
    {
        $I->amOnPage(LoginPage::URL);
    }

    /**
     * Проверка входа с невалидным логином и паролем
     */
    public function loginWithInvalidCredentials(AcceptanceTester $I): void
    {
        $I->fillField(
            LoginPage::LOGIN_INPUT,
            'test@test.com'
        );

        $I->fillField(
            LoginPage::PASSWORD_INPUT,
            'invalid_password'
        );

        $I->click(LoginPage::SUBMIT_BUTTON);

        $I->waitForElementVisible(
            LoginPage::ERROR_MESSAGE,
            10
        );

        $I->see(
            LoginPage::INVALID_CREDENTIALS_TEXT,
            LoginPage::ERROR_MESSAGE
        );
    }

    /**
     * Отправка формы с пустыми полями
     */
    public function loginWithEmptyFields(AcceptanceTester $I): void
    {
        $I->click(LoginPage::SUBMIT_BUTTON);

        $I->waitForText(
            LoginPage::EMAIL_REQUIRED_ERROR,
            10
        );

        $I->see(
            LoginPage::EMAIL_REQUIRED_ERROR,
            LoginPage::ERROR_MESSAGE
        );

        $I->see(
            LoginPage::PASSWORD_REQUIRED_ERROR,
            LoginPage::ERROR_MESSAGE
        );

        $I->seeInCurrentUrl(LoginPage::URL);
    }

    /**
     * Проверка маскировки пароля
     */
    public function passwordShouldBeMasked(AcceptanceTester $I): void
    {
        $I->fillField(
            LoginPage::PASSWORD_INPUT,
            'SecretPassword123!'
        );

        $passwordType = $I->grabAttributeFrom(
            LoginPage::PASSWORD_INPUT,
            'type'
        );

        $I->assertSame(
            'password',
            $passwordType,
            'Поле пароля должно иметь type="password"'
        );
    }

    /**
     * Проверка ссылки "Забыли пароль"
     */
    public function forgotPasswordLinkShouldWork(AcceptanceTester $I): void
    {
        $I->seeElement(
            LoginPage::FORGOT_PASSWORD_LINK
        );

        $I->click(
            LoginPage::FORGOT_PASSWORD_LINK
        );

        $I->waitForElementVisible('form', 10);

        $I->seeInCurrentUrl('/site/restore-password');
    }

    // All `public` methods will be executed as tests.
    public function tryToTest(AcceptanceTester $I): void
    {
        // Write your test content here.
    }
}
