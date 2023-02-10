# APIClientMaker
## from LT/Utils

How to set up in symfony:
1. Install with
```
    composer require latvijas-talrunis/api-auth-client-maker
```
In the case of your project not being able to find the ClientMaker. This might help:
```
    composer dump-autoload
```

2. Update your project's
```
services:
    LT\Utils\ApiClientMaker\ClientMaker:
        arguments:
            $authServiceUrl: '%env(string:AUTH_SERVICE_URL)%'
            $authServiceUser: '%env(string:AUTH_SERVICE_USER)%'
            $authServicePassword: '%env(string:AUTH_SERVICE_PASSWORD)%'
```
3. Update your .env file with these 3 variables
```
    AUTH_SERVICE_URL=http://url.to.the.auth.service
    AUTH_SERVICE_USER=root
    AUTH_SERVICE_PASSWORD=
```

4. And for the controller:

It needs a class property in which to keep the instantiated ClientMaker
```
    public $clientMaker;
```

It needs to be set up in the clients constructor
```
    public function __construct(ApiClientMaker $serviceMediatorClientMaker){
    $this->clientMaker = $serviceMediatorClientMaker;
    }
```

And then it will be available in every method of this particular controller
``` 
    #[Route('/test')]
    public function index(): Response
    {
    // authorized symfony http client
    $client = $this->clientMaker->getClient();
    }
```
