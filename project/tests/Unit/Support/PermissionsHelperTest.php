<?php

namespace Tests\Unit\Support;

use App\Support\PermissionsHelper;
use PHPUnit\Framework\TestCase;

class PermissionsHelperTest extends TestCase
{
    public function testShouldKeepSimplePermissions()
    {
        $this->assertEquals(
            ['permission'],
            PermissionsHelper::getFlattenPermissions(['permission'])
        );
    }

    public function testAllowRepeatedPermissions()
    {
        $this->assertEquals(
            ['permission', 'permission'],
            PermissionsHelper::getFlattenPermissions(['permission', 'permission'])
        );
    }

    public function testShouldFlattenNestedPermissions()
    {
        $this->assertEquals(
            ['users show', 'users update'],
            PermissionsHelper::getFlattenPermissions(['users' => ['show', 'update']])
        );

        $this->assertEquals(
            ['users show'],
            PermissionsHelper::getFlattenPermissions(['users' => 'show'])
        );

        $this->assertEquals(
            ['users show', 'users update', 'users profile show'],
            PermissionsHelper::getFlattenPermissions(
                ['users' => ['show', 'update', 'profile' => ['show']]]
            )
        );
    }

    public function testShouldFlattenMixedPermissions()
    {
        $this->assertEquals(
            ['users show', 'users update', 'simple permission'],
            PermissionsHelper::getFlattenPermissions(
                ['users' => ['show', 'update'], 'simple permission']
            )
        );

        $this->assertEquals(
            ['users avatar change', 'users show', 'simple permission'],
            PermissionsHelper::getFlattenPermissions(
                ['users' => ['avatar' => 'change', 'show'], 'simple permission']
            )
        );
    }

    public function testPrependedGlobalPrefix()
    {
        $this->assertEquals(
            ['user avatar change', 'user show'],
            PermissionsHelper::getFlattenPermissions(['avatar' => 'change', 'show'], 'user')
        );
    }

    public function testShouldTrimPermissions()
    {
        $this->assertEquals(
            ['permission'],
            PermissionsHelper::getFlattenPermissions(['  permission  '])
        );

        $this->assertEquals(
            ['permission'],
            PermissionsHelper::getFlattenPermissions([' ' => ['   permission']])
        );

        $this->assertEquals(
            ['user show'],
            PermissionsHelper::getFlattenPermissions(['  user  ' => ' show '])
        );

        $this->assertEquals(
            ['users show', 'users update'],
            PermissionsHelper::getFlattenPermissions(['users' => [' show ', ' update ']])
        );
    }
}
