<?php

/*
 * This file is part of the Mce package.
 *
 * (c) Matthew Conger-Eldeen <mceldeen@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mce\Date;

use \Mce\Date\Math as DateMath;
use \DateTime;

/**
 * Test class for Math.
 * Generated by PHPUnit on 2012-05-16 at 20:38:16.
 */
class MathTest extends \PHPUnit_Framework_TestCase
{
    
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp () {
        
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown () {
        
    }

    /**
     * @covers Mce\Date\Math::getWeekRange
     */
    public function testGetWeekRange() {
        $date = new DateTime("2012-03-01 12:00:00");
        $weekStart = 1;
        
        $range = DateMath::getWeekRange($date, $weekStart);
        
        $this->assertEquals($range->getStart(), new DateTime("2012-02-27 00:00:00"));
        $this->assertEquals($range->getEnd(),   new DateTime("2012-03-04 23:59:59"));
    }

    /**
     * @covers Mce\Date\Math::getWeekOfMonthRange
     */
    public function testGetWeekOfMonthRange () {
        $date = new DateTime("2012-02-01 12:00:00");
        $weekStart = 1;
        $weekOfMonth = 4;
        
        $rangeClass = "\\Mce\\Date\\RangeInclusive";
        
        $range = DateMath::getWeekOfMonthRange($weekOfMonth, $date, $weekStart);
        
        $this->assertEquals($range->getStart(), new DateTime("2012-02-27 00:00:00"));
        $this->assertEquals($range->getEnd(),   new DateTime("2012-03-04 23:59:59"));
    }

    /**
     * @covers Mce\Date\Math::getWeekOfMonthNumber
     */
    public function testGetWeekOfMonthNumber () {
        $date = new DateTime("2012-03-01 12:00:00");
        $date2 = new DateTime("2012-03-12 12:00:00");
        $weekStart = 1;
               
        $this->assertEquals(4, DateMath::getWeekOfMonthNumber($date, $weekStart));
        $this->assertEquals(2, DateMath::getWeekOfMonthNumber($date2, $weekStart));
    }

    /**
     * @covers Mce\Date\Math::getMonthRange
     */
    public function testGetMonthRange () {
        $date = new DateTime("2012-03-03 12:00:00");
         
        $range = DateMath::getMonthRange($date);
               
        $this->assertEquals(new DateTime("2012-03-01 00:00:00"), $range->getStart());
        $this->assertEquals(new DateTime("2012-03-31 23:59:59"), $range->getEnd());
    }
    
    /**
     * @covers Mce\Date\Math::getFirstWeekdayOfMonth
     */
    public function testGetFirstWeekdayOfMonth () {
        $date = new DateTime("2012-03-01 12:00:00");
        $weekStart = 1;
               
        $this->assertEquals(new DateTime("2012-03-05 00:00:00"),  DateMath::getFirstWeekdayOfMonth($weekStart, $date));
    }
    
    /**
     * @covers Mce\Date\Math::getNWeekdayOfMonth
     */
    public function testGetNWeekdayOfMonth () {
        $date = new DateTime("2012-02-01 12:00:00");
        $weekDay = 1;
        $n = 4;
               
        $this->assertEquals(new DateTime("2012-02-27 00:00:00"),  DateMath::getNWeekdayOfMonth($n, $weekDay, $date));
    }

}
?>
