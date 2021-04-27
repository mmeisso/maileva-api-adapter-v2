<?php

namespace MailevaApiAdapter\App;

/**
 * Class MailevaSendingStatus
 *
 * @package MailevaApiAdapter\App
 */
class MailevaSendingStatus
{

    const ACCEPTED = "ACCEPTED";
    const CANCELED = "CANCELED";
    const DRAFT = "DRAFT";
    const ERROR = "ERROR";
    const FULL_PROCESSED_LRE = "FULL_PROCESSED_LRE";
    const PAYMENT_REQUIRED = "PAYMENT_REQUIRED";
    const PENDING = "PENDING";
    const PROCESSED = "PROCESSED";
    const PROCESSED_WITH_ERRORS = "PROCESSED_WITH_ERRORS";
    const REFUNDED = 'REFUNDED';
    const REJECTED = "REJECTED";
    const SUBMIT_ERROR = "SUBMIT_ERROR";
}
