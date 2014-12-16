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
 * @package   RawPHP\RawMail
 * @author    Tom Kaczohca <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */

namespace RawPHP\RawMail;

use PHPMailer;
use RawPHP\RawDispatcher\Contract\IDispatcher;
use RawPHP\RawMail\Contract\IMail;
use RawPHP\RawMail\Event\Events;
use RawPHP\RawMail\Event\SendMailEvent;
use RawPHP\RawMail\Exception\MailException;

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
class Mail implements IMail
{
    /** @var  array */
    public $to = [ ];
    /** @var  PHPMailer */
    public $mailer = NULL;
    /** @var  IDispatcher */
    protected $dispatcher = NULL;

    /**
     * Create new mail service.
     *
     * @param array       $config
     * @param IDispatcher $dispatcher
     */
    public function __construct( array $config = [], IDispatcher $dispatcher = NULL )
    {
        $this->dispatcher = $dispatcher;

        $this->init( $config );
    }

    /**
     * Initialises the mailer.
     *
     * @param array $config configuration array
     *
     * @action ON_INIT_ACTION
     */
    public function init( $config = NULL )
    {
        $this->mailer = new PHPMailer();

        foreach ( $config as $key => $value )
        {
            switch ( $key )
            {
                case 'from_email':
                    $this->mailer->From = $value;
                    break;

                case 'from_name':
                    $this->mailer->FromName = $value;
                    break;

                case 'is_html':
                    $this->mailer->isHTML( ( bool ) $value );
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
    }

    /**
     * Sets the TO: email address.
     *
     * @param array $to address and optional name
     *                  e.g.,
     *                  <pre>
     *                  array( 'address' => 'address@example.com,
     *                  'name'    => 'John Smith' );
     *                  </pre>
     *
     * @return bool TRUE on success, FALSE on failure
     *
     * @throws MailException
     */
    public function addTo( $to = [ ] )
    {
        $this->to[ ] = $to;

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
            throw new MailException( 'Something went wrong with adding TO recipient' );
        }

        return $result;
    }

    /**
     * Sets the subject parameter.
     *
     * @param string $subject the message subject
     *
     * @action ON_SET_SUBJECT_ACTION
     */
    public function setSubject( $subject )
    {
        $this->mailer->Subject = $subject;
    }

    /**
     * Sets the message body.
     *
     * @param string $body the message subject
     *
     * @action ON_SET_BODY_ACTION
     */
    public function setBody( $body )
    {
        $this->mailer->Body = $body;
    }

    /**
     * Adds an attachment to the email.
     *
     * @param string $attachment attachment file path
     *
     * @filter ON_ADD_ATTACHMENT_FILTER
     *
     * @action ON_ADD_ATTACHMENT_ACTION
     */
    public function addAttachment( $attachment )
    {
        $this->mailer->addAttachment( $attachment );
    }

    /**
     * Adds a CC address to the email.
     *
     * @param mixed $email email string or email|name array
     *                     array( 'name' => 'Information', 'email' => 'name@email.com' );
     *
     * @action ON_ADD_CC_ACTION
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
    }

    /**
     * Adds a BCC address to the email.
     *
     * @param mixed $email email string or email|name array
     *                     array( 'name' => 'Information', 'email' => 'name@email.com' );
     *
     * @action ON_ADD_BCC_ACTION
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
    }

    /**
     * Sends the email.
     *
     * @action ON_BEFORE_SEND_ACTION
     * @action ON_AFTER_SEND_ACTION
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public function send()
    {
        $result = $this->mailer->send();

        if ( NULL !== $this->dispatcher )
        {
            $event = new SendMailEvent( $this->to, $this->getSubject(), $this->getBody(), $result );

            $this->dispatcher->fire( Events::EVENT_SEND_MESSAGE, $event );
        }

        return $result;
    }

    /**
     * Returns the To recipients.
     *
     * @return array list of recipients
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Gets the From name.
     *
     * @return string From name
     */
    public function getFromName()
    {
        return $this->mailer->FromName;
    }

    /**
     * Gets the From address.
     *
     * @return string From email address
     */
    public function getFromAddress()
    {
        return $this->mailer->From;
    }

    /**
     * Returns the Subject.
     *
     * @return string the subject
     */
    public function getSubject()
    {
        return $this->mailer->Subject;
    }

    /**
     * Returns the Body.
     *
     * @return string the body
     */
    public function getBody()
    {
        return $this->mailer->Body;
    }

    /**
     * Returns the SMTP host.
     *
     * @return string the host
     */
    public function getSmtpHost()
    {
        return $this->mailer->Host;
    }

    /**
     * Returns the SMTP port.
     *
     * @return int the port
     */
    public function getSmtpPort()
    {
        return $this->mailer->Port;
    }
}
