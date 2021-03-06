<?php
require_once dirname(__FILE__) . '/../src/Autoload/LogInterface.php';
require_once dirname(__FILE__) . '/../src/Autoload/Log.php';
require_once dirname(__FILE__) . '/../src/Autoload/Info.php';
require_once dirname(__FILE__) . '/../src/Autoload.php';

Class AutoloadTest extends PHPUnit_Framework_TestCase
{
    private $_log;

    public function setUp()
    {
        $this->_log = new \Dm\Utils\Autoload\Log(false);
    }

    /**
     * @param $file
     * @param $dir
     * @param $useRelativePath
     * @param $expected
     * @dataProvider providerTestGetMap
     */
    public function testGetMap($file, $dir, $useRelativePath, $expected)
    {
        $classMap = new \Dm\Utils\Autoload($file, $dir, '', $useRelativePath, $this->_log);
        $classMap->run();
        $classMap->getMap();

        $actual = $classMap->getMap();
        $this->assertEquals($actual, $expected);
    }

    public function providerTestGetMap()
    {
        $data = array();
        $data[] = array(
            'file' => dirname(__FILE__) . '/source/autoload.php',
            'dir' => dirname(__FILE__) . '/source/',
            'useRelativePath' => true,
            'expected' => array(
                'Glob\\Fifa' => 'first.php',
                'Glob\\Story' => 'first.php',
                'Bar\\OtherClass' => 'first.php',
                'Bar\\AABBC' => 'first.php',
                'Bar\\Test' => 'first.php',
                'Bar\\TestInterface' => 'first.php',
                'EmptyClass' => 'first.php',
                'OtherFileClass' => 'four.php',
                'One\\Two\\Three\\FourClass' => 'five.php',
                'CheckUse\\FiveClass' => 'five.php',
                'TestTrait' => 'trait.php'
            )
        );
        $data[] = array(
            'file' => dirname(__FILE__) . '/other/autoload.php',
            'dir' => dirname(__FILE__) . '/source/',
            'useRelativePath' => true,
            'expected' => array(
                'Glob\\Fifa' => '../source/first.php',
                'Glob\\Story' => '../source/first.php',
                'Bar\\OtherClass' => '../source/first.php',
                'Bar\\AABBC' => '../source/first.php',
                'Bar\\Test' => '../source/first.php',
                'Bar\\TestInterface' => '../source/first.php',
                'EmptyClass' => '../source/first.php',
                'OtherFileClass' => '../source/four.php',
                'One\\Two\\Three\\FourClass' => '../source/five.php',
                'CheckUse\\FiveClass' => '../source/five.php',
                'TestTrait' => '../source/trait.php'
            )
        );
        $data[] = array(
            'file' => dirname(__FILE__) . '/source/autoloader.php',
            'dir' => dirname(__FILE__) . '/source/',
            'useRelativePath' => false,
            'expected' => array(
                'Glob\\Fifa' => dirname(__FILE__) . '/source/first.php',
                'Glob\\Story' => dirname(__FILE__) . '/source/first.php',
                'Bar\\OtherClass' => dirname(__FILE__) . '/source/first.php',
                'Bar\\AABBC' => dirname(__FILE__) . '/source/first.php',
                'Bar\\Test' => dirname(__FILE__) . '/source/first.php',
                'Bar\\TestInterface' => dirname(__FILE__) . '/source/first.php',
                'EmptyClass' => dirname(__FILE__) . '/source/first.php',
                'OtherFileClass' => dirname(__FILE__) . '/source/four.php',
                'One\\Two\\Three\\FourClass' => dirname(__FILE__) . '/source/five.php',
                'CheckUse\\FiveClass' => dirname(__FILE__) . '/source/five.php',
                'TestTrait' => dirname(__FILE__) . '/source/trait.php'
            )
        );

        return $data;
    }
}