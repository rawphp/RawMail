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

use RawPHP\RawBase\Component;
use RawPHP\RawMail\IMail;
use RawPHP\RawBase\Exceptions\RawException;

/**
 * An email handler service.
 * 
 * The current implementation is just a wrapper over the PHPMailer.
 * 
 * @category  PHP
 * @package   RawPHP/RawMail
 * @author    Tom Kaczocha <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 * @see       https://github.com/Synchro/PHPMailer
 */
class Mail extends Component implements IMail
{
    public $mailer = NULL;
    
    /**
     * Initialises the mailer.
     * 
     * @param array $config configuration array
     */
    public function init( $config = array( ) )
    {
        $this->mailer = new \PHPMailer( );
        
        foreach( $config as $key => $value )
        {
            switch( $key )
            {
                case 'from_email':
                    $this->mailer->From = $value;
                    break;
                
                case 'from_name':
                    $this->mailer->FromName = $value;
                    break;
                
                case 'is_html':
                    $this->mailer->isHTML( $value );
                    break;
                
                case 'smtp':
                    if ( !empty( $value ) )
                    {
                        // mark it as SMTP mail
                        $this->mailer->isSMTP();
                        
                        $this->mailer->Host       = $value[ 'host' ];
                        $this->mailer->SMTPAuth   = $value[ 'auth' ];
                        $this->mailer->Username   = $value[ 'username' ];
                        $this->mailer->Password   = $value[ 'password' ];
                        $this->mailer->SMTPSecure = $value[ 'security' ];
                        $this->mailer->Port       = $value[ 'port' ];
                    }
                    break;
                
                case 'reply_to':
                    if ( !empty( $value ) )
                    {
                        $this->mailer->addReplyTo( $value[ 'email' ], $value[ 'name' ] );
                    }
                    break;
                    
                default:
                    // do nothing
                    break;
            }
        }
        
        $this->doAction( self::ON_MAIL_INIT_ACTION );
    }
    
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
    public function addTo( $to = array( ) )
    {
        $to = $this->filter( self::ON_MAIL_ADD_TO_FILTER, $to );
        
        if ( is_array( $to ) )
        {
            $result = $this->mailer->addAddress( $to[ 'address' ], $to[ 'name' ] );
        }
        elseif ( is_string( $to ) )
        {
            $result = $this->mailer->addAddress( $to );
        }
        else
        {
            throw new Exception( 'Something went wrong with adding TO recipient' );
        }
        
        $this->doAction( self::ON_MAIL_ADD_TO_ACTION );
        
        return $result;
    }
    
    /**
     * Sets the subject parameter.
     * 
     * @param string $subject the message subject
     * 
     * @action ON_MAIL_SET_SUBJECT_ACTION
     */
    public function setSubject( $subject )
    {
        $this->mailer->Subject = $subject;
        
        $this->doAction( self::ON_MAIL_SET_SUBJECT_ACTION );
    }
    
    /**
     * Sets the message body.
     * 
     * @param string $body the message subject
     * 
     * @action ON_MAIL_SET_BODY_ACTION
     */
    public function setBody( $body )
    {
        $this->mailer->Body = $body;
        
        $this->doAction( self::ON_MAIL_SET_BODY_ACTION );
    }
    
    /**
     * Adds an attachment to the email.
     * 
     * @param string $attachment attachment file path
     * 
     * @filter ON_MAIL_ADD_ATTACHMENT_FILTER
     * 
     * @action ON_MAIL_ADD_ATTACHMENT_ACTION
     */
    public function addAttachment( $attachment )
    {
        $this->mailer->addAttachment( $this->filter( self::ON_MAIL_ADD_ATTACHMENT_FILTER, $attachment ) );
        
        $this->doAction( self::ON_MAIL_ADD_ATTACHMENT_ACTION );
    }
    
    /**
     * Adds a CC address to the email.
     * 
     * @param mixed $email email string or email|name array
     *                     array( 'name' => 'Information', 'email' => 'name@email.com' );
     * 
     * @action ON_MAIL_ADD_CC_ACTION
     */
    public function addCC( $email )
    {
        if ( is_array( $email ) )
        {
            $this->mailer->addCC( $email[ 'email' ], $email[ 'name' ] );
        }
        else
        {
            $this->mailer->addCC( $email );
        }
        
        $this->doAction( self::ON_MAIL_ADD_CC_ACTION );
    }
    
    /**
     * Adds a BCC address to the email.
     * 
     * @param mixed $email email string or email|name array
     *                     array( 'name' => 'Information', 'email' => 'name@email.com' );
     * 
     * @action ON_MAIL_ADD_BCC_ACTION
     */
    public function addBCC( $email )
    {
        if ( is_array( $email ) )
        {
            $this->mailer->addBCC( $email[ 'email' ], $email[ 'name' ] );
        }
        else
        {
            $this->mailer->addBCC( $email );
        }
        
        $this->doAction( self::ON_MAIL_ADD_BCC_ACTION );
    }
    
    /**
     * Sends the email.
     * 
     * @action ON_MAIL_BEFORE_SEND_ACTION
     * @action ON_MAIL_AFTER_SEND_ACTION
     * 
     * @return bool TRUE on success, FALSE on failure
     */
    public function send( )
    {
        $this->doAction( self::ON_MAIL_BEFORE_SEND_ACTION );
        
        $result = $this->mailer->send();
        
        $this->doAction( self::ON_MAIL_AFTER_SEND_ACTION );
        
        return $result;
    }
    
    const ON_MAIL_INIT_ACTION           = 'on_mail_init_action';
    const ON_MAIL_ADD_TO_ACTION         = 'on_mail_add_to_action';
    const ON_MAIL_SET_SUBJECT_ACTION    = 'on_mail_set_subject_action';
    const ON_MAIL_SET_BODY_ACTION       = 'on_mail_set_body_action';
    const ON_MAIL_ADD_ATTACHMENT_ACTION = 'on_mail_add_attachment_action';
    const ON_MAIL_ADD_CC_ACTION         = 'on_mail_add_cc_action';
    const ON_MAIL_ADD_BCC_ACTION        = 'on_mail_add_bcc_action';
    const ON_MAIL_BEFORE_SEND_ACTION    = 'on_mail_before_send_action';
    const ON_MAIL_AFTER_SEND_ACTION     = 'on_mail_after_send_action';
    
    const ON_MAIL_ADD_TO_FILTER         = 'on_mail_add_to_filter';
    const ON_MAIL_ADD_ATTACHMENT_FILTER = 'on_mail_add_attachment_filter';
    
}
