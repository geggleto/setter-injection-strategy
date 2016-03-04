[![Build Status](https://travis-ci.org/geggleto/setter-injection-strategy.svg?branch=master)](https://travis-ci.org/geggleto/setter-injection-strategy)

# setter-injection-strategy

This package is intended to replace the default Invocation handler in Slim. 
This strategy forces controllers to implement `SetterInjectionReceiver` which tells Slim to set the Response, Request, and Arg instead of
passing it through the method signature. This saves space on all of your action methods in your controller.

In short it will turn this.
```php
class abcController {
  //...
  public function myAction (Request $request, Response $response, $args = []) {
    //..
  }
  //...
}
```

Into This.
```php
class abcController implements SetterInjectionReceiver {
  //.. Implement and store the Objects somewhere up here.
  //...
  public function myAction () {
    //..  This is now much more Slim 2 style
  }
  //...
}
```

Or this if you have arguments
```php
class abcController implements SetterInjectionReceiver {
  //.. Implement and store the Objects somewhere up here.
  //...
  public function myAction ($arg1, $arg2, $arg3) {
    //..  This is now much more Slim 2 style
  }
  //...
}
```

## Install
This package is available via Composer. `composer install geggleto/setter-strategy`

## Usage

There are some configuration changes you will need to make in your Slim application.
**If you only wish to use SetterInjection on some of your callables, It will default back to using the RequestResponseArgs style if your controller does not implement the Receiver Interface**

```php
// Setup the Strategy in the container by adding a factory method like below.
  $container['foundHandler'] = function ($c) {
      return new SetterInjectionStrategy();
  };
```
