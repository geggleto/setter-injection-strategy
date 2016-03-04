<?php
/**
 * Created by PhpStorm.
 * User: Glenn
 * Date: 2016-03-04
 * Time: 9:36 AM
 */

namespace Geggleto\Strategy;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface SetterInjectionReceiver
{
    public function setRequest(ServerRequestInterface $request);
    public function setResponse(ResponseInterface $response);
}