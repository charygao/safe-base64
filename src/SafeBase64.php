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

class SafeBase64
{
    /**
     * @param string $data
     * @return string The encoded data, as a string.
     */
    public static function encode($data)
    {
        ($str = base64_encode($data)) && $str = strtr(rtrim($str, '='), '+/', '-_');

        return $str;
    }

    /**
     * @param string $data
     * @param bool $strict [optional]
     * @return string|bool the original data or false on failure. The returned data may be binary
     */
    public static function decode($data, $strict = false)
    {
        $data = strtr($data, '-_', '+/') . str_repeat('=', (4 - strlen($data) & 3) & 3);

        return base64_decode($data, $strict);
    }
}