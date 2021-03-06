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

/**
 * @author Matthew Conger-Eldeen <mceldeen@gmail.com>
 */
interface RangeInterface {
    
    public function __construct(\DateTime $start, \DateTime $end);
   
    /**
     * @return \DateTime the start of the range
     */
    public function getStart();
    
    /**
     * @return \DateTime the end of the range
     */
    public function getEnd();

    /**
     * @param  String|\DateTime 
     * @return bool true if in range and false if not
     */
    public function contains(\DateTime $date);
}
?>
