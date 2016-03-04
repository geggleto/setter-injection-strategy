<?php
namespace Geggleto\Tests;

use Geggleto\Tests\Controllers\TestController;
use Geggleto\Strategy\SetterInjectionStrategy;
use Geggleto\Tests\Controllers\TestFallBack;
use Slim\Http\Environment;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\RequestBody;
use Slim\Http\UploadedFile;
use Slim\Http\Uri;

/**
 * Created by PhpStorm.
 * User: Glenn
 * Date: 2016-01-05
 * Time: 11:02 AM
 */
class SetterStrategyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Slim\App
     */
    protected $app;


    /**
     * @return Request
     */
    public function requestFactory()
    {
        $env = Environment::mock();
        $uri = Uri::createFromString('https://example.com/test');
        $headers = Headers::createFromEnvironment($env);
        $cookies = [
            'user' => 'john',
            'id' => '123',
        ];
        $serverParams = $env->all();
        $body = new RequestBody();
        $uploadedFiles = UploadedFile::createFromEnvironment($env);
        $request = new Request('GET', $uri, $headers, $cookies, $serverParams, $body, $uploadedFiles);

        return $request;
    }

    public function setUp ()
    {
        $this->app = new \Slim\App();
    }

    public function testInjectionReceiverAndStrategy() {
        $container = $this->app->getContainer();

        $container['foundHandler'] = function ($c) {
            return new SetterInjectionStrategy();
        };
        $container['request'] = $this->requestFactory();

        $container[TestController::class] = function ($c) {
          return new TestController();
        };

        $this->app->get('/test', TestController::class.":testMethod");

        $resOut = $this->app->run(true);

        $resOut->getBody()->rewind();

        $this->assertInstanceOf('\Psr\Http\Message\ResponseInterface', $resOut);
        $this->assertEquals("Hi",  (string)$resOut->getBody());
    }

    public function testFallBackStrategy() {
        $container = $this->app->getContainer();

        $container['request'] = $this->requestFactory();

        $container[TestFallBack::class] = function ($c) {
            return new TestFallBack();
        };

        $this->app->get('/test', TestFallBack::class.":testOtherMethod");

        $resOut = $this->app->run(true);

        $resOut->getBody()->rewind();

        $this->assertInstanceOf('\Psr\Http\Message\ResponseInterface', $resOut);
        $this->assertEquals("Hi",  (string)$resOut->getBody());


    }

}
