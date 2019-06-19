<?php
/**
 * Created by PhpStorm.
 * User: killian-reso
 * Date: 2019-06-19
 * Time: 10:00
 */

namespace MailevaApiAdapter\App\Core;

interface MailevaResponseInterface
{

    /**
     * @return array
     */
    public function getResponseAsArray(): array;


}