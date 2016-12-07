<?php
/**
 * GpsLab component.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2016, Peter Gribanov
 * @license   http://opensource.org/licenses/MIT
 */

namespace GpsLab\Bundle\DateBundle\Tests;

use Symfony\Component\Translation\TranslatorInterface;
use GpsLab\Bundle\DateBundle\Formatter;

class FormatterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|TranslatorInterface
     */
    protected $translator;

    /**
     * @var Formatter
     */
    protected $formatter;

    /**
     * @var \DateTime
     */
    protected $date;

    protected function setUp()
    {
        $this->translator = $this->getMock(TranslatorInterface::class);
        $this->formatter = new Formatter($this->translator);
        $this->date = new \DateTime('2016-07-20 14:06:32', new \DateTimeZone('Europe/Moscow'));
    }

    /**
     * @return array
     */
    public function getFormats()
    {
        return [
            ['djNSwzWmntLoYyaABgGhHisuI', '20203th3201290773112016201616pmPM504214021406320000000'],
            ['e', 'Europe/Moscow'],
            ['O', '+0300'],
            ['P', '+03:00'],
            ['T', 'MSK'],
            ['Z', '10800'],
            ['c', '2016-07-20T14:06:32+03:00'],
            ['r', 'Wed, 20 Jul 2016 14:06:32 +0300'],
            ['U', '1469012792'],
            // test escaping
            ['\U', 'U'],
            ['\\U', 'U'],
            ['\\\U', '\1469012792'],
            ['\\\\U', '\1469012792'],
            ['\\\\\U', '\U'],
            ['\\\\\\U', '\U'],
            // test translate chars
            ['f', '|month.genitive.july|'],
            ['\f', 'f'], // escaping
            ['D', '|weekday.short.wednesday|'],
            ['l', '|weekday.long.wednesday|'],
            ['F', '|month.long.july|'],
            ['M', '|month.short.july|'],
            // translated word has format char
            ['fe', '|month.genitive.july|Europe/Moscow'],
        ];
    }

    /**
     * @dataProvider getFormats
     *
     * @param string $format
     * @param string $expected
     */
    public function testFormat($format, $expected)
    {
        $this->translator
            ->expects($this->any())
            ->method('trans')
            ->will($this->returnCallback(function ($id, $parameters, $domain) {
                $this->assertEquals([], $parameters);
                $this->assertEquals('date', $domain);

                return '|'.$id.'|';
            }));

        $this->assertEquals($expected, $this->formatter->format($this->date, $format));
    }

    /**
     * @return array
     */
    public function getPassedDates()
    {
        return [
            [
                new \DateTime('-10 minutes -40 seconds'),
                'passed.minutes_ago',
                ['%minutes%' => 11],
                '10 минут назад',
            ],
            [
                new \DateTime('+15 minutes'),
                'passed.in_minutes',
                ['%minutes%' => 15],
                'Через 15 минут',
            ],
            [
                ($date = new \DateTime('+2 hour')),
                'passed.today',
                ['%time%' => $date->format('H:i')],
                'Сегодня в '.$date->format('H:i'),
            ],
            [
                ($date = new \DateTime('-1 day')),
                'passed.yesterday',
                ['%time%' => $date->format('H:i')],
                'Вчера в '.$date->format('H:i'),
            ],
            [
                ($date = new \DateTime('+1 day')),
                'passed.tomorrow',
                ['%time%' => $date->format('H:i')],
                'Завтра в '.$date->format('H:i'),
            ],
            [
                ($date = new \DateTime('+2 day')),
                '',
                [],
                $date->format('d f \a\t H:i'),
            ],
            [
                ($date = new \DateTime('+1 year')),
                '',
                [],
                $date->format('d f Y \a\t H:i'),
            ],
        ];
    }

    /**
     * @dataProvider getPassedDates
     *
     * @param \DateTime $date
     * @param string $trans
     * @param array $parameters
     * @param string $expected
     */
    public function testPassed(\DateTime $date, $trans, array $parameters, $expected)
    {
        if ($trans) {
            $this->translator
                ->expects($this->once())
                ->method('trans')
                ->with($trans, $parameters, 'date')
                ->will($this->returnValue($expected));
        } else {
            $this->translator
                ->expects($this->once())
                ->method('trans')
                ->with('month.genitive.'.strtolower($date->format('F')), $parameters, 'date')
                ->will($this->returnValue('f'));
        }

        $this->assertEquals($expected, $this->formatter->passed($date));
    }
}
