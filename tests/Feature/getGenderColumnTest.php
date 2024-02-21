<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Users;

class getGenderColumnTest extends TestCase
{
    public function testGetGenderColumn()
    {

        $this->assertEquals("gender",  Users::getGenderColumn());
    }

}
