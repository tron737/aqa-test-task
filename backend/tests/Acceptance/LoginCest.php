<?php

declare(strict_types=1);

namespace Tests\Acceptance;

use Codeception\Attribute\Examples;
use Codeception\Example;
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
    #[Examples(
        email: 'test@test.com',
        password: 'invalid_password',
        errorSelector: LoginPage::ERROR_MESSAGE,
        error: LoginPage::INVALID_CREDENTIALS_TEXT
    )]
    #[Examples(
        email: 'test@example.com',
        password: '123',
        errorSelector: LoginPage::ERROR_MESSAGE,
        error: LoginPage::INVALID_CREDENTIALS_TEXT
    )]
    #[Examples(
        email: 'not-existing-user@example.com',
        password: 'Qwerty123!',
        errorSelector: LoginPage::ERROR_MESSAGE,
        error: LoginPage::INVALID_CREDENTIALS_TEXT
    )]
    #[Examples(
        email: 'not-email',
        password: 'Qwerty123!',
        errorSelector: LoginPage::EMAIL_ERROR_MESSAGE,
        error: LoginPage::INVALID_EMAIL_TEXT
    )]
    public function loginWithInvalidCredentials(AcceptanceTester $I, Example $example): void
    {
        $I->fillField(
            LoginPage::LOGIN_INPUT,
            $example['email']
        );

        $I->fillField(
            LoginPage::PASSWORD_INPUT,
            $example['password']
        );

        $I->click(LoginPage::SUBMIT_BUTTON);

        $I->waitForElementVisible(element: $example['errorSelector'], timeout: 10);

        $I->see(text: $example['error'], selector: $example['errorSelector']);
    }

    /**
     * Отправка формы с пустыми полями
     */
    public function loginWithEmptyFields(AcceptanceTester $I): void
    {
        $I->click(LoginPage::SUBMIT_BUTTON);

        $I->waitForText(LoginPage::EMAIL_REQUIRED_ERROR, 10);

        $I->see(LoginPage::EMAIL_REQUIRED_ERROR, LoginPage::ERROR_MESSAGE);

        $I->see(LoginPage::PASSWORD_REQUIRED_ERROR, LoginPage::ERROR_MESSAGE);

        $I->seeInCurrentUrl(LoginPage::URL);
    }

    /**
     * Проверка маскировки пароля
     */
    public function passwordShouldBeMasked(AcceptanceTester $I): void
    {
        $I->fillField(LoginPage::PASSWORD_INPUT, 'SecretPassword123!');

        $passwordType = $I->grabAttributeFrom(LoginPage::PASSWORD_INPUT, 'type');

        $I->assertSame('password', $passwordType, 'Поле пароля должно иметь type="password"');
    }

    /**
     * Проверка ссылки "Забыли пароль"
     */
    public function forgotPasswordLinkShouldWork(AcceptanceTester $I): void
    {
        $I->seeElement(LoginPage::FORGOT_PASSWORD_LINK);

        $I->click(LoginPage::FORGOT_PASSWORD_LINK);

        $I->waitForElementVisible('form', 10);

        $I->seeInCurrentUrl('/site/restore-password');
    }
}
