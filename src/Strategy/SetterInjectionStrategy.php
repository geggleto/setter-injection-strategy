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
use Slim\Interfaces\InvocationStrategyInterface;

class SetterInjectionStrategy implements InvocationStrategyInterface
{

    /**
     * Invoke a route callable.
     *
     * @param callable $callable The callable to invoke using the strategy.
     * @param ServerRequestInterface $request The request object.
     * @param ResponseInterface $response The response object.
     * @param array $routeArguments The route's placholder arguments
     *
     * @return ResponseInterface|string The response from the callable.
     */
    public function __invoke(
        callable $callable,
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $routeArguments
    )
    {
        $target = $callable[0];
        if ($target instanceof SetterInjectionReceiver) {
            $target->setRequest($request);
            $target->setResponse($response);
            $target->setArgs($routeArguments);

            return call_user_func($callable);

        } else { //If it all fails, fallback
            return call_user_func($callable, $request, $response, $routeArguments);
        }
    }
}