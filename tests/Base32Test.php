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

namespace Pengzhile\Utils\SafeBase64\Tests;

use Pengzhile\Utils\SafeBase64\Base32;
use PHPUnit_Framework_TestCase;

class Base32Test extends PHPUnit_Framework_TestCase
{
    protected $oldErrorMode;

    protected function setUp()
    {
        parent::setUp();

        $this->oldErrorMode = error_reporting(-1);
    }

    protected function tearDown()
    {
        parent::tearDown();

        error_reporting($this->oldErrorMode);
    }

    /**
     * @param int $length
     * @return string
     */
    protected function randomBytes($length)
    {
        if ((int)$length < 1) {
            return '';
        }

        $bytes = array();

        for ($i = 0; $i < $length; $i++) {
            $bytes[] = mt_rand(0, 255);
        }

        return implode('', $bytes);
    }

    public function testEncodeDecode()
    {
        for ($i = 0; $i < 1000; $i++) {
            $str = $this->randomBytes(mt_rand(1, 1024));

            $content = Base32::decode(Base32::encode($str));
            $this->assertEquals($str, $content);
        }
    }
}
