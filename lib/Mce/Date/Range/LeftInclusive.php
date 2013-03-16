<?php
namespace Mce\Date\Range;

/**
 * @author Matthew Conger-Eldeen <mceldeen@gmail.com>
 */
class LeftInclusive extends \Mce\Date\RangeAbstract
{
    public function contains(\DateTime $date)
    {
        return $this->getStart() <= $date && $date < $this->getEnd();
    }
}