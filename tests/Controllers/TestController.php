<?php
namespace Geggleto\Tests\Controllers;

use Geggleto\Strategy\SetterInjectionReceiver;
use Interop\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TestController implements SetterInjectionReceiver
{
    /**
     * @var ServerRequestInterface
     */
    protected $request;

    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var array
     */
    protected $args;


    public function __construct()
    {
    }

    /**
     * @param ServerRequestInterface $request
     */
    public function setRequest(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * @param ResponseInterface $response
     */
    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;
    }
    
    /**
     * @return ServerRequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }


    /**
     * @return ResponseInterface
     */
    public function testMethod() {
        return $this->response->write("Hi");
    }

    public function testOtherMethod($req, $res, $args) {
        return $res->write("Hi");
    }

    public function testMethodArgs($id) {
        return $this->response->write($id);
    }

}