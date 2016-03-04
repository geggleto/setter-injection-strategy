<?php
namespace Geggleto\Tests\Controllers;

use Geggleto\Strategy\SetterInjectionReceiver;
use Interop\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TestFallBack
{
     public function testOtherMethod($req, $res, $args) {
        return $res->write("Hi");
    }
}