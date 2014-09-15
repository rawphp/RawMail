<?php

/**
 * This file is part of RawPHP - a PHP Framework.
 * 
 * Copyright (c) 2014 RawPHP.org
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
 * 
 * PHP version 5.4
 * 
 * @category  PHP
 * @package   RawPHP/RawMail
 * @author    Tom Kaczohca <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */

$config = array();

/*******************************************************************************
 * Email Settings
 * -----------------------------------------------------------------------------
 * Mail and SMTP settings used to send emails using SMTP.
 * 
 ******************************************************************************/
$config[ 'from_email' ]   = 'no-reply@rawphp.org';                // default from email to use in emails
$config[ 'from_name' ]    = 'RawPHP';                             // default from name to use in emails

$config[ 'smtp' ][ 'auth' ]         = TRUE;                       // enable SMTP authentication
$config[ 'smtp' ][ 'host' ]         = 'smtp.gmail.com';           // main and backup SMTP servers
$config[ 'smtp' ][ 'username' ]     = 'username';                 // SMTP username
$config[ 'smtp' ][ 'password' ]     = 'password';                 // SMTP password
$config[ 'smtp' ][ 'security' ]     = 'ssl';                      // Enable TLS encryption, 'ssl' also accepted
$config[ 'smtp' ][ 'port' ]         = '465';                      // SMTP port


return $config;