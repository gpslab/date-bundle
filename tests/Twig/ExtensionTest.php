<?php
/**
 * GpsLab component.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2016, Peter Gribanov
 * @license   http://opensource.org/licenses/MIT
 */

namespace GpsLab\Bundle\DateBundle\Tests\Twig;

use GpsLab\Bundle\DateBundle\Comparator;
use GpsLab\Bundle\DateBundle\Converter;
use GpsLab\Bundle\DateBundle\Formatter;
use GpsLab\Bundle\DateBundle\Twig\Extension;

class ExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|Formatter
     */
    private $formatter;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|Converter
     */
    private $converter;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|Comparator
     */
    private $comparator;

    /**
     * @var Extension
     */
    private $extension;

    protected function setUp()
    {
        $this->formatter = $this
            ->getMockBuilder(Formatter::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $this->converter = $this->getMock(Converter::class);
        $this->comparator = $this->getMock(Comparator::class);

        $this->extension = new Extension($this->formatter, $this->converter, $this->comparator);
    }

    public function testGetFilters()
    {
        $filters = $this->extension->getFilters();

        $this->assertInternalType('array', $filters);
        $this->assertEquals(2, count($filters));
        foreach ($filters as $filter) {
            $this->assertInstanceOf(\Twig_SimpleFilter::class, $filter);
        }

        /* @var $date \Twig_SimpleFilter */
        /* @var $date_passed \Twig_SimpleFilter */
        list($date, $date_passed) = $filters;

        $this->assertEquals('date', $date->getName());
        $this->assertEquals([$this->extension, 'getDateFormat'], $date->getCallable());
        $this->assertTrue($date->needsEnvironment());

        $this->assertEquals('date_passed', $date_passed->getName());
        $this->assertEquals([$this->extension, 'getDatePassed'], $date_passed->getCallable());
    }

    public function testGetFunctions()
    {
        $filters = $this->extension->getFunctions();

        $this->assertInternalType('array', $filters);
        $this->assertEquals(6, count($filters));
        foreach ($filters as $filter) {
            $this->assertInstanceOf(\Twig_SimpleFunction::class, $filter);
        }

        /* @var $compare_date_time \Twig_SimpleFunction */
        /* @var $compare_date \Twig_SimpleFunction */
        /* @var $compare_time \Twig_SimpleFunction */
        /* @var $compare_week \Twig_SimpleFunction */
        /* @var $compare_month \Twig_SimpleFunction */
        /* @var $compare_year \Twig_SimpleFunction */
        list(
            $compare_date_time,
            $compare_date,
            $compare_time,
            $compare_week,
            $compare_month,
            $compare_year
        ) = $filters;

        $this->assertEquals('compare_date_time', $compare_date_time->getName());
        $this->assertEquals([$this->extension, 'getCompareDateTime'], $compare_date_time->getCallable());

        $this->assertEquals('compare_date', $compare_date->getName());
        $this->assertEquals([$this->extension, 'getCompareDate'], $compare_date->getCallable());

        $this->assertEquals('compare_time', $compare_time->getName());
        $this->assertEquals([$this->extension, 'getCompareTime'], $compare_time->getCallable());

        $this->assertEquals('compare_week', $compare_week->getName());
        $this->assertEquals([$this->extension, 'getCompareWeek'], $compare_week->getCallable());

        $this->assertEquals('compare_month', $compare_month->getName());
        $this->assertEquals([$this->extension, 'getCompareMonth'], $compare_month->getCallable());

        $this->assertEquals('compare_year', $compare_year->getName());
        $this->assertEquals([$this->extension, 'getCompareYear'], $compare_year->getCallable());
    }

    public function testGetDateFormatDateIntervalFromFormat()
    {
        /* @var $env \PHPUnit_Framework_MockObject_MockObject|\Twig_Environment */
        $env = $this->getMock(\Twig_Environment::class);
        $date = new \DateInterval('P2Y4DT6H8M');
        $format = '%Y %M %D %H %I %S %R';

        $this->assertEquals($date->format($format), $this->extension->getDateFormat($env, $date, $format));
    }

    public function testGetDateFormatDateInterval()
    {
        $formats = [
            'Y-m-d H:i:s',
            '%Y %M %D %H %I %S %R',
        ];

        /* @var $env \PHPUnit_Framework_MockObject_MockObject|\Twig_Extension_Core */
        $core = $this->getMock(\Twig_Extension_Core::class);
        $core
            ->expects($this->once())
            ->method('getDateFormat')
            ->will($this->returnValue($formats))
        ;

        /* @var $env \PHPUnit_Framework_MockObject_MockObject|\Twig_Environment */
        $env = $this->getMock(\Twig_Environment::class);
        $env
            ->expects($this->once())
            ->method('getExtension')
            ->with('core')
            ->will($this->returnValue($core))
        ;
        $date = new \DateInterval('P2Y4DT6H8M');

        $this->assertEquals($date->format($formats[1]), $this->extension->getDateFormat($env, $date));
    }

    public function testGetDateFormatFromFormat()
    {
        /* @var $env \PHPUnit_Framework_MockObject_MockObject|\Twig_Environment */
        $env = $this->getMock(\Twig_Environment::class);
        $date = new \DateTime();
        $format = 'Y-m-d H:i:s';

        $this->converter
            ->expects($this->once())
            ->method('getDateTime')
            ->with($date)
            ->will($this->returnValue($date))
        ;

        $this->formatter
            ->expects($this->once())
            ->method('format')
            ->with($date, $format)
            ->will($this->returnValue($date->format($format)))
        ;

        $this->assertEquals($date->format($format), $this->extension->getDateFormat($env, $date, $format));
    }

    public function testGetDateFormat()
    {
        $formats = [
            'Y-m-d H:i:s',
            '%Y %M %D %H %I %S %R',
        ];

        /* @var $env \PHPUnit_Framework_MockObject_MockObject|\Twig_Extension_Core */
        $core = $this->getMock(\Twig_Extension_Core::class);
        $core
            ->expects($this->once())
            ->method('getDateFormat')
            ->will($this->returnValue($formats))
        ;

        /* @var $env \PHPUnit_Framework_MockObject_MockObject|\Twig_Environment */
        $env = $this->getMock(\Twig_Environment::class);
        $env
            ->expects($this->once())
            ->method('getExtension')
            ->with('core')
            ->will($this->returnValue($core))
        ;
        $date = new \DateTime();

        $this->converter
            ->expects($this->once())
            ->method('getDateTime')
            ->with($date)
            ->will($this->returnValue($date))
        ;

        $this->formatter
            ->expects($this->once())
            ->method('format')
            ->with($date, $formats[0])
            ->will($this->returnValue($date->format($formats[0])))
        ;

        $this->assertEquals($date->format($formats[0]), $this->extension->getDateFormat($env, $date));
    }

    public function testGetDatePassed()
    {
        $date = new \DateTime();
        $format = 'Y-m-d H:i:s';

        $this->converter
            ->expects($this->once())
            ->method('getDateTime')
            ->with($date)
            ->will($this->returnValue($date))
        ;

        $this->formatter
            ->expects($this->once())
            ->method('passed')
            ->with($date, 'time_format', 'month_format', 'year_format')
            ->will($this->returnValue($date->format($format)))
        ;

        $this->assertEquals(
            $date->format($format),
            $this->extension->getDatePassed($date, 'time_format', 'month_format', 'year_format')
        );
    }

    public function testCompareDateTime()
    {
        $this->converter
            ->expects($this->at(0))
            ->method('getDateTime')
            ->with('x')
            ->will($this->returnValue(new \DateTime('16:30')))
        ;
        $this->converter
            ->expects($this->at(1))
            ->method('getDateTime')
            ->with('y')
            ->will($this->returnValue(new \DateTime('16:00')))
        ;

        $this->comparator
            ->expects($this->once())
            ->method('compareDateTime')
            ->with(new \DateTime('16:30'), '>', new \DateTime('16:00'))
            ->will($this->returnValue(true))
        ;

        $this->assertTrue($this->extension->getCompareDateTime('x', '>', 'y'));
    }

    public function testCompareDate()
    {
        $this->converter
            ->expects($this->at(0))
            ->method('getDateTime')
            ->with('x')
            ->will($this->returnValue(new \DateTime('16:30')))
        ;
        $this->converter
            ->expects($this->at(1))
            ->method('getDateTime')
            ->with('y')
            ->will($this->returnValue(new \DateTime('16:00')))
        ;

        $this->comparator
            ->expects($this->once())
            ->method('compareDate')
            ->with(new \DateTime('16:30'), '>', new \DateTime('16:00'))
            ->will($this->returnValue(true))
        ;

        $this->assertTrue($this->extension->getCompareDate('x', '>', 'y'));
    }

    public function testCompareTime()
    {
        $this->converter
            ->expects($this->at(0))
            ->method('getDateTime')
            ->with('x')
            ->will($this->returnValue(new \DateTime('16:30')))
        ;
        $this->converter
            ->expects($this->at(1))
            ->method('getDateTime')
            ->with('y')
            ->will($this->returnValue(new \DateTime('16:00')))
        ;

        $this->comparator
            ->expects($this->once())
            ->method('compareTime')
            ->with(new \DateTime('16:30'), '>', new \DateTime('16:00'))
            ->will($this->returnValue(true))
        ;

        $this->assertTrue($this->extension->getCompareTime('x', '>', 'y'));
    }

    public function testCompareWeek()
    {
        $this->converter
            ->expects($this->at(0))
            ->method('getDateTime')
            ->with('x')
            ->will($this->returnValue(new \DateTime('16:30')))
        ;
        $this->converter
            ->expects($this->at(1))
            ->method('getDateTime')
            ->with('y')
            ->will($this->returnValue(new \DateTime('16:00')))
        ;

        $this->comparator
            ->expects($this->once())
            ->method('compareWeek')
            ->with(new \DateTime('16:30'), '>', new \DateTime('16:00'))
            ->will($this->returnValue(true))
        ;

        $this->assertTrue($this->extension->getCompareWeek('x', '>', 'y'));
    }

    public function testCompareMonth()
    {
        $this->converter
            ->expects($this->at(0))
            ->method('getDateTime')
            ->with('x')
            ->will($this->returnValue(new \DateTime('16:30')))
        ;
        $this->converter
            ->expects($this->at(1))
            ->method('getDateTime')
            ->with('y')
            ->will($this->returnValue(new \DateTime('16:00')))
        ;

        $this->comparator
            ->expects($this->once())
            ->method('compareMonth')
            ->with(new \DateTime('16:30'), '>', new \DateTime('16:00'))
            ->will($this->returnValue(true))
        ;

        $this->assertTrue($this->extension->getCompareMonth('x', '>', 'y'));
    }

    public function testCompareYear()
    {
        $this->converter
            ->expects($this->at(0))
            ->method('getDateTime')
            ->with('x')
            ->will($this->returnValue(new \DateTime('16:30')))
        ;
        $this->converter
            ->expects($this->at(1))
            ->method('getDateTime')
            ->with('y')
            ->will($this->returnValue(new \DateTime('16:00')))
        ;

        $this->comparator
            ->expects($this->once())
            ->method('compareYear')
            ->with(new \DateTime('16:30'), '>', new \DateTime('16:00'))
            ->will($this->returnValue(true))
        ;

        $this->assertTrue($this->extension->getCompareYear('x', '>', 'y'));
    }

    public function testGetName()
    {
        $this->assertEquals('gpslab_date_extension', $this->extension->getName());
    }
}
