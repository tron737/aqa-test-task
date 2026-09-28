<?php

namespace Tests\Support\Helper;

use Codeception\Module;

class Acceptance extends Module
{
    public function createTestUserDirectlyInDb(array $overrides = []): array
    {
        $user = array_merge(
            [
                'email' => 'test@test.com',
                'password_hash' => password_hash(
                    'Qwerty123!',
                    PASSWORD_BCRYPT
                )
            ],
            $overrides
        );

        $this->debugSection(
            'Test user inserted into DB (mock)',
            $user
        );

        return $user;
    }
}