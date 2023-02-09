<?php

namespace Tests;


abstract class TestWebCase extends TestCase
{
    public function setUp() : void
    {
        parent::setUp();
        
        $this->withoutMix();
    }
}
