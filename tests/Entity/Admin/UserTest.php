<?php

namespace App\Tests\Entity\Admin;

use App\Entity\Admin\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testSettingsLength()
    {
        $user = new User();

        $this->assertSame(null, $user->getTall());

        $user->setTall(120);

        $this->assertSame(120, $user->getTall());
    }
}