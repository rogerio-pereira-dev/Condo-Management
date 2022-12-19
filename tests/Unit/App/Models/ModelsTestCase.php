<?php
namespace Tests\Unit\App\Models;

use Tests\TestCase;
use Illuminate\Database\Eloquent\Model;

abstract class ModelsTestCase extends TestCase 
{
    abstract protected function model() : Model;

    abstract protected function expectedTraits() : array;

    abstract protected function expectedFillable() : array;

    abstract protected function expectedHidden() : array;

    abstract protected function expectedCasts() : array;

    public function testTraits()
    {
        $traits = class_uses($this->model());    //Return Traits of class
        $traits = array_keys($traits);

        $expectedTraits = $this->expectedTraits();

        $this->assertEquals($expectedTraits, $traits);
    }

    public function testFillable()
    {
        $fillable = $this->model()->getFillable();

        $expectedFillable = $this->expectedFillable();

        $this->assertEquals($expectedFillable, $fillable);
    }

    public function testHidden()
    {
        $hidden = $this->model()->getHidden();

        $expectedHidden = $this->expectedHidden();

        $this->assertEquals($expectedHidden, $hidden);
    }

    public function testCasts()
    {
        $casts = $this->model()->getCasts();

        $expectedCasts = $this->expectedCasts();

        $this->assertEquals($expectedCasts, $casts);
    }

    // public function testIncrementingIsFalse()
    // {
    //     $incrementing = $this->model()->incrementing;

    //     $this->assertFalse($incrementing);
    // }
}