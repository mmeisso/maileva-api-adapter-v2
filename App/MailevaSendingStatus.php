<?php

namespace MailevaApiAdapter\App;

/**
 * Class MailevaSendingStatus
 * @package MailevaApiAdapter\App
 */
class MailevaSendingStatus
{
    const DRAFT = "DRAFT";
    const PAYMENT_REQUIRED = "PAYMENT_REQUIRED";
    const PENDING = "PENDING";
    const ACCEPTED = "ACCEPTED";
    const REJECTED = "REJECTED";
    const PROCESSED = "PROCESSED";
    const PROCESSED_WITH_ERRORS = "PROCESSED_WITH_ERRORS";
    const ERROR = "ERROR";

}