<?php

namespace MailevaApiAdapter\tests\_support\Helper\MailevaSending;

use MailevaApiAdapter\App\MailevaApiAdapter;
use MailevaApiAdapter\App\MailevaSending as MailevaSendingApp;

abstract class MailevaSendingAbstract
{
    const NOTIFICATION_EMAIL = 'lpettiti@eukles.com';

    abstract public function getMailevaSending(MailevaApiAdapter $mailevaApiAdapter): MailevaSendingApp;
}