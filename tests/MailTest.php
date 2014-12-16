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
 * PHP version 5.3
 *
 * @category  PHP
 * @package   RawPHP/RawMail
 * @author    Tom Kaczohca <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */

namespace RawPHP\RawMail\Tests;

use PHPUnit_Framework_TestCase;
use RawPHP\RawMail\Mail;

/**
 * This is the logging class.
 *
 * @category  PHP
 * @package   RawPHP/RawMail
 * @author    Tom Kaczocha <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */
class MailTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Mail
     */
    public $mail;

    private $_to = [ 'address' => 'test@example.com', 'name' => 'John Smith' ];
    private $_subject = 'Test Subject';
    private $_body = 'Test message body';

    /**
     * Setup before each test.
     */
    public function setup()
    {
        global $config;

        $this->mail = new Mail( $config );

        $this->mail->setSubject( $this->_subject );
        $this->mail->setBody( $this->_body );
    }

    /**
     * Cleanup after each test.
     */
    public function tearDown()
    {
        $this->mail = NULL;
    }

    /**
     * Test log instantiated correctly.
     */
    public function testMailInstantiatedSuccessfully()
    {
        $this->assertNotNull( $this->mail );
    }

    /**
     * Test mail setup correctly.
     *
     * @global array $config configuration array
     */
    public function testMailSetupCorrectly()
    {
        global $config;

        $this->assertEquals( $config[ 'from_email' ], $this->mail->mailer->From );
        $this->assertEquals( $config[ 'from_name' ], $this->mail->mailer->FromName );

        $this->mail->addTo( $this->_to );

        $this->assertEquals( $this->_subject, $this->mail->mailer->Subject );
        $this->assertEquals( $this->_body, $this->mail->mailer->Body );

        $this->assertEquals( $config[ 'smtp' ][ 'host' ], $this->mail->mailer->Host );
        $this->assertEquals( $config[ 'smtp' ][ 'username' ], $this->mail->mailer->Username );
        $this->assertEquals( $config[ 'smtp' ][ 'password' ], $this->mail->mailer->Password );
        $this->assertEquals( $config[ 'smtp' ][ 'security' ], $this->mail->mailer->SMTPSecure );
        $this->assertEquals( $config[ 'smtp' ][ 'port' ], $this->mail->mailer->Port );
    }

    /**
     * Test mail fails to send with bad SMTP creds.
     */
    public function testMailFailsToSendWithBadSmtpCredentials()
    {
        $this->mail->addTo( $this->_to );

        $this->assertFalse( $this->mail->send() );
    }
}