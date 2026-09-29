<?php

declare(strict_types=1);

namespace Tests\Support\Page\Acceptance;

class LoginPage
{
    public const URL = '/login';

    public const LOGIN_INPUT = '#loginform-email';

    public const PASSWORD_INPUT = '#loginform-password';

    public const SUBMIT_BUTTON = 'button[type="submit"]';

    public const FORGOT_PASSWORD_LINK = '#login-form a[href*="restore-password"]';

    public const ERROR_MESSAGE = '#login-form .has-error .help-block-error';

    public const INVALID_CREDENTIALS_TEXT = 'Incorrect email / password';
    public const EMAIL_ERROR_MESSAGE = '#login-form .field-loginform-email .help-block-error';
    public const INVALID_EMAIL_TEXT = 'Invalid email';

    public const EMAIL_REQUIRED_ERROR = 'Email cannot be blank.';
    public const PASSWORD_REQUIRED_ERROR = 'Password cannot be blank.';
}