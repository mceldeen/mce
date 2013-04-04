<?php

/*
 * This file is part of the Mce package.
 *
 * (c) Matthew Conger-Eldeen <mceldeen@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mce\Date\Math;

use \DateTime;
use \Mce\Date\Range\Inclusive as InclusiveRange;

/**
 * Test class for Math.
 * Generated by PHPUnit on 2012-05-16 at 20:38:16.
 */
class MonthTest extends \PHPUnit_Framework_TestCase
{
    
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp ()
    { 
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown ()
    {
    }

    /**
     * @covers Mce\Date\Math\Month::getRange
     */
    public function testGetRange()
    {
        $date = new DateTime("2013-04-13 12:00:00");

        $expectedRange = new InclusiveRange(
            new DateTime('2013-04-01 00:00:00'),
            new DateTime('2013-04-30 23:59:59')
        );

        $range = Month::getRange($date);

        $this->assertEquals($range->getStart(), $expectedRange->getStart());
        $this->assertEquals($range->getEnd(),   $expectedRange->getEnd());
    }

    /**
     * @covers Mce\Date\Math\Month::getFirstWeekDay
     */
    public function testGetFirstWeekDay()
    {
        $tests = array(
            'before' => array( // the day of the week of the 1st is less than $weekday
                'month' => new DateTime('2013-04-01'),
                'weekday' => 3,
                'expected' => new DateTime('2013-04-03')
            ),
            'on' => array( // the day of the week of the 1st is the same as $weekday
                'month' => new DateTime('2013-04-01'),
                'weekday' => 1,
                'expected' => new DateTime('2013-04-01')
            ),
            'after' => array( // the day of the week of the first is greater than $weekday
                'month' => new DateTime('2013-05-01'),
                'weekday' => 1,
                'expected' => new DateTime('2013-05-06')
            )
        );

        foreach($tests as $name => $test) {
            $actual = Month::getFirstWeekDay($test['weekday'], $test['month']);
            $this->assertEquals($actual, $test['expected'], "$name test case failed"); 
        }
    }

    /**
     * @covers Mce\Date\Math\Month::getNWeekday
     */
    public function testGetNWeekday()
    {

        // test the basic functionality
        $n = 3;
        $weekday = 3;
        $month = new DateTime('2013-04-01');
        $expected = new DateTime('2013-04-17');
        $actual = Month::getNWeekday($n, $weekday, $month);
        $this->assertEquals($actual, $expected);

        // out of bounds
        $n = 5;
        $this->setExpectedException('\RangeException');
        Month::getNWeekday(5, $weekday, $month);
    }
}
