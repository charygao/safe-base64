<?php
/**
 * This file is part of the SafeBase64 package.
 *
 * MIT License
 *
 * Copyright (C) 2017 pengzhile <pengzhile@gmail.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace Pengzhile\Utils\SafeBase64;

/**
 * Class Base32
 * @package Pengzhile\Utils\SafeBase64
 */
class Base32
{
    /**
     * @var string
     */
    protected static $digits = 'abcdefghijklmnopqrstuvwxyz234567';

    /**
     * @var array
     */
    protected static $map = array(
        'a' => 0, 'b' => 1, 'c' => 2, 'd' => 3, 'e' => 4, 'f' => 5, 'g' => 6, 'h' => 7,
        'i' => 8, 'j' => 9, 'k' => 10, 'l' => 11, 'm' => 12, 'n' => 13, 'o' => 14, 'p' => 15,
        'q' => 16, 'r' => 17, 's' => 18, 't' => 19, 'u' => 20, 'v' => 21, 'w' => 22, 'x' => 23,
        'y' => 24, 'z' => 25, '2' => 26, '3' => 27, '4' => 28, '5' => 29, '6' => 30, '7' => 31,
    );

    /**
     * @param string $value
     * @return string
     */
    public static function encode($value)
    {
        $result = array();
        $current = 0;
        $length = strlen($value);

        while ($length > 4) {
            list(, $c1, $c2, $c3, $c4, $c5) = unpack('C5', substr($value, $current, 5));

            $result[] = self::$digits{$c1 >> 3};
            $result[] = self::$digits{($c1 & 0x7) << 2 | $c2 >> 6};
            $result[] = self::$digits{($c2 & 0x3E) >> 1};
            $result[] = self::$digits{($c2 & 0x1) << 4 | $c3 >> 4};
            $result[] = self::$digits{($c3 & 0xF) << 1 | $c4 >> 7};
            $result[] = self::$digits{($c4 & 0x7C) >> 2};
            $result[] = self::$digits{($c4 & 0x3) << 3 | $c5 >> 5};
            $result[] = self::$digits{$c5 & 0x1F};

            $current += 5;
            $length -= 5;
        }

        switch ($length) {
            case 4:
                list(, $c1, $c2, $c3, $c4) = unpack('C4', substr($value, -4));

                $result[] = self::$digits{$c1 >> 3};
                $result[] = self::$digits{($c1 & 0x7) << 2 | $c2 >> 6};
                $result[] = self::$digits{($c2 & 0x3E) >> 1};
                $result[] = self::$digits{($c2 & 0x1) << 4 | $c3 >> 4};
                $result[] = self::$digits{($c3 & 0xF) << 1 | $c4 >> 7};
                $result[] = self::$digits{($c4 & 0x7C) >> 2};
                $result[] = self::$digits{($c4 & 0x3) << 3};
                break;
            case 3:
                $c1 = ord($value{$current});
                $c2 = ord($value{$current + 1});
                $c3 = ord($value{$current + 2});

                $result[] = self::$digits{$c1 >> 3};
                $result[] = self::$digits{($c1 & 0x7) << 2 | $c2 >> 6};
                $result[] = self::$digits{($c2 & 0x3E) >> 1};
                $result[] = self::$digits{($c2 & 0x1) << 4 | $c3 >> 4};
                $result[] = self::$digits{($c3 & 0xF) << 1};
                break;
            case 2:
                $c1 = ord($value{$current});
                $c2 = ord($value{$current + 1});

                $result[] = self::$digits{$c1 >> 3};
                $result[] = self::$digits{($c1 & 0x7) << 2 | $c2 >> 6};
                $result[] = self::$digits{($c2 & 0x3E) >> 1};
                $result[] = self::$digits{($c2 & 0x1) << 4};
                break;
            case 1:
                $c1 = ord($value{$current});

                $result[] = self::$digits{$c1 >> 3};
                $result[] = self::$digits{($c1 & 0x7) << 2};
                break;
            case 0:
                break;
        }

        return implode('', $result);
    }

    /**
     * @param string $str
     * @return string
     */
    public static function decode($str)
    {
        $result = array();
        $current = 0;
        $length = strlen($str);

        while ($length > 7) {
            $i1 = self::$map[$str{$current}];
            $i2 = self::$map[$str{$current + 1}];
            $i3 = self::$map[$str{$current + 2}];
            $i4 = self::$map[$str{$current + 3}];
            $i5 = self::$map[$str{$current + 4}];
            $i6 = self::$map[$str{$current + 5}];
            $i7 = self::$map[$str{$current + 6}];
            $i8 = self::$map[$str{$current + 7}];

            $result[] = pack('C5', $i1 << 3 | $i2 >> 2, $i2 << 6 | $i3 << 1 | $i4 >> 4, $i4 << 4 | $i5 >> 1, $i5 << 7 | $i6 << 2 | $i7 >> 3, $i7 << 5 | $i8);

            $current += 8;
            $length -= 8;
        }

        switch ($length) {
            case 7:
                $i1 = self::$map[$str{$current}];
                $i2 = self::$map[$str{$current + 1}];
                $i3 = self::$map[$str{$current + 2}];
                $i4 = self::$map[$str{$current + 3}];
                $i5 = self::$map[$str{$current + 4}];
                $i6 = self::$map[$str{$current + 5}];
                $i7 = self::$map[$str{$current + 6}];

                $result[] = pack('C4', $i1 << 3 | $i2 >> 2, $i2 << 6 | $i3 << 1 | $i4 >> 4, $i4 << 4 | $i5 >> 1, $i5 << 7 | $i6 << 2 | $i7 >> 3);
                break;
            case 5:
                $i1 = self::$map[$str{$current}];
                $i2 = self::$map[$str{$current + 1}];
                $i3 = self::$map[$str{$current + 2}];
                $i4 = self::$map[$str{$current + 3}];
                $i5 = self::$map[$str{$current + 4}];

                $result[] = pack('C3', $i1 << 3 | $i2 >> 2, $i2 << 6 | $i3 << 1 | $i4 >> 4, $i4 << 4 | $i5 >> 1);
                break;
            case 4:
                $i1 = self::$map[$str{$current}];
                $i2 = self::$map[$str{$current + 1}];
                $i3 = self::$map[$str{$current + 2}];
                $i4 = self::$map[$str{$current + 3}];

                $result[] = chr($i1 << 3 | $i2 >> 2);
                $result[] = chr($i2 << 6 | $i3 << 1 | $i4 >> 4);
                break;
            case 2:
                $i1 = self::$map[$str{$current}];
                $i2 = self::$map[$str{$current + 1}];

                $result[] = chr($i1 << 3 | $i2 >> 2);
                break;
            case 0:
                break;
            default:
                return false;
        }

        return implode('', $result);
    }
}
