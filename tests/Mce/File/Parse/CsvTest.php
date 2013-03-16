<?php
namespace Mce\File\Parse;

require_once __DIR__ . '/../../../../lib/Mce/File/Exception/NotFound.php';
require_once __DIR__ . '/../../../../lib/Mce/File/Exception/NotReadable.php';
require_once __DIR__ . '/../../../../lib/Mce/File/Parse/CsvInterface.php';
require_once __DIR__ . '/../../../../lib/Mce/File/Parse/Csv.php';
require_once 'vfsStream/vfsStream.php';

use \vfsStream as vfsStream;
use \vfsStreamDirectory as vfsStreamDirectory;
use \vfsStreamWrapper as vfsStreamWrapper;

/**
 * Test class for Csv.
 * Generated by PHPUnit on 2012-05-05 at 21:09:12.
 */
class CsvTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var Csv
     */
    protected $csv;
    
    protected $largeCsv;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->csv = new Csv;
        $this->largeCsv = realpath(__DIR__ . "/../../../data/LargeCsv.csv");
        
        vfsStreamWrapper::register();
        vfsStreamWrapper::setRoot(new vfsStreamDirectory('root'));
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        unset($this->csv);
    }

    public function testFileNotFoundExceptionWithNonExistentFile() {
        $this->setExpectedException("\\Mce\\File\\Exception\\NotFound");
        $this->csv->parse(vfsStream::url('root/NonExistentFile.csv'));
    }

    public function testFileNotReadableExceptionWithNonReadableFile() {
        $this->setExpectedException("\\Mce\\File\\Exception\\NotReadable");
        vfsStream::newFile('NonReadableFile.csv', 0333)->at(vfsStreamWrapper::getRoot());
        $this->csv->parse(vfsStream::url('root/NonReadableFile.csv'));
    }
       
    public function testParseReturnsRowsMinusOneWithHeaderRow() {       
        $actualRows = (10000 - 1);
        $rows = $this->csv->parse($this->largeCsv);
        $this->assertTrue($rows == $actualRows, "Csv::parse returned " . $rows . " rows instead of the correct " . $actualRows . " rows.");
    }
    
    public function testParseReturnsRowsWithoutHeaderRow() {       
        $actualRows = 10000;
        $rows = $this->csv->parse($this->largeCsv, false);
        $this->assertTrue($rows == $actualRows, "Csv::parse returned " . $rows . " rows instead of the correct " . $actualRows . " rows.");
    }
    
    public function testSetCallbackReturnsThis() {
        $callback = function($n , $row) { };
        $this->assertTrue($this->csv->setCallback($callback) === $this->csv);
    }
    
    public function testParseCallsCallbackForEachRow() {
        $rows = 0;
        $callback = function($n , $row) use(&$rows) {
            $rows++;
        };
        $this->csv->setCallback($callback);
        
        $actualRows = 10000;
        $this->csv->parse($this->largeCsv, false);
        $this->assertTrue($rows == $actualRows, "The callback was called for " . $rows . " rows instead of the correct " . $actualRows . " rows.");
    }
    
    public function testParseCallsCallbackForEachRowExcludingHeader() {
        $rows = 0;
        $callback = function($n , $row) use(&$rows) {
            $rows++;
        };
        $this->csv->setCallback($callback);
        
        $actualRows = (10000 - 1);
        $this->csv->parse($this->largeCsv);
        $this->assertTrue($rows == $actualRows, "The callback was called for " . $rows . " rows instead of the correct " . $actualRows . " rows.");
    }
    
    public function testParseCallsCallbackWithCorrectData() {
        $rows = 0;
        $csvColumns = 3;
        $success = true;
        $callback = function($n , $row) use($csvColumns, &$rows, &$success) {
            if($n !== $rows && count($row) !== $csvColumns) {
                $success = false;
            }
            $rows++;
        };
        $this->csv->setCallback($callback);
        
        $actualRows = (10000 - 1);
        $this->csv->parse($this->largeCsv);
        $this->assertTrue($success, "The callback was not passed the correct data.");
    }
    
    public function testParseUsesHeadersWhenSet() {
        $success = true;
        $callback = function($n, $row) use(&$success) {
            if(!isset($row['foo']) || !isset($row['bar']) || !isset($row['dateTime'])) {
                $success = false;
            }
        };
        $this->csv->setCallback($callback)
                  ->parse($this->largeCsv);
        $this->assertTrue($success, "The correct headers were not set.");
    }
    
    public function testParseDoesNotUseHeadersWhenNotSet() {
        $success = true;
        $callback = function($n, $row) use(&$success) {
            if(isset($row['foo']) || isset($row['bar']) || isset($row['dateTime'])) {
                $success = false;
            }
        };
        $this->csv->setCallback($callback)
                  ->parse($this->largeCsv, false);
        $this->assertTrue($success, "The headers were set when they weren't supposed to.");
    }
}