<?php

/**
 * This file is part of Step in Deals application.
 *
 * Copyright (c) 2014 Tom Kaczocha
 *
 * This Source Code is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, you can obtain one at http://mozilla.org/MPL/2.0/.
 *
 * PHP version 5.4
 *
 * @category  PHP
 * @package   RawPHP\RawMail\Event
 * @author    Tom Kaczohca <tom@crazydev.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://crazydev.org/licenses/mpl.txt MPL
 * @link      http://crazydev.org/
 */

namespace RawPHP\RawMail\Event;

use RawPHP\RawSupport\Event\BaseEvent;

/**
 * Class SendMailEvent
 *
 * @package RawPHP\RawMail\Event
 */
class SendMailEvent extends BaseEvent
{
    /** @var  array */
    protected $to;
    /** @var  string */
    protected $subject;
    /** @var  string */
    protected $message;
    /** @var  int */
    protected $result;

    /**
     * Create new event.
     *
     * @param array  $to
     * @param string $subject
     * @param string $message
     * @param int    $result
     */
    public function __construct( array $to, $subject, $message, $result )
    {
        $this->to      = $to;
        $this->subject = $subject;
        $this->message = $message;
        $this->result  = $result;
    }

    /**
     * Get to list.
     *
     * @return array
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Set to list.
     *
     * @param array $to
     */
    public function setTo( array $to )
    {
        $this->to = $to;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set subject.
     *
     * @param string $subject
     */
    public function setSubject( $subject )
    {
        $this->subject = $subject;
    }

    /**
     * Get message.
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set message.
     *
     * @param string $message
     */
    public function setMessage( $message )
    {
        $this->message = $message;
    }

    /**
     * Get result.
     *
     * @return int
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Set result.
     *
     * @param int $result
     */
    public function setResult( $result )
    {
        $this->result = $result;
    }

}