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

namespace RawPHP\RawMail;

/**
 * The mail interface.
 * 
 * @category  PHP
 * @package   RawPHP/RawMail
 * @author    Tom Kaczocha <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */
interface IMail
{
    /**
     * Initialises the mailer.
     * 
     * @param array $config configuration array
     */
    public function init( $config = array( ) );
    
    /**
     * Sets the TO: email address.
     * 
     * @param array $to address and optional name
     *                  e.g., <code>
     *                          array( 'address' => 'address@example.com,
     *                                 'name'    => 'John Smith' );
     *                        </code>
     * 
     * @filter ON_MAIL_ADD_TO_FILTER
     * 
     * @action ON_MAIL_ADD_TO_ACTION
     * 
     * @return bool TRUE on success, FALSE on failure
     */
    public function addTo( $to = array( ) );
    
    /**
     * Sets the subject parameter.
     * 
     * @param string $subject the message subject
     */
    public function setSubject( $subject );
    
    /**
     * Sets the message body.
     * 
     * @param string $body the message subject
     */
    public function setBody( $body );
    
    /**
     * Adds an attachment to the email.
     * 
     * @param string $attachment attachment file path
     */
    public function addAttachment( $attachment );
    
    /**
     * Adds a CC address to the email.
     * 
     * @param mixed $email email string or email|name array
     *                     array( 'name' => 'Information', 'email' => 'name@email.com' );
     */
    public function addCC( $email );
    
    /**
     * Adds a BCC address to the email.
     * 
     * @param mixed $email email string or email|name array
     *                     array( 'name' => 'Information', 'email' => 'name@email.com' );
     */
    public function addBCC( $email );
    
    /**
     * Sends the email.
     * 
     * @return bool TRUE on success, FALSE on failure
     */
    public function send( );
}
