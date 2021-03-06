# Project 7: Create a web service exposing an API

I was charged to develop a REST API for the society BileMo which is a phone seller.
The goal of the project is to set a platform where BileMo can propose their phones to others companies and control the customer administration. 

## 1/Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### 2/Prerequisites

* Composer
* Database
* PHP Server
* Facebook App (refer to this tutorial if you don't knw how to get it: https://www.nukesuite.com/fr/support/social-applications/creating-application-from-facebook-developers/)

### 3/Installing

### API

* Clone the project in your repository.
* Run a composer install
* Fill the field during the installation (Database host, Database password, API key...)

That's it!

### Frontend

You have an available frontend premade to work with : https://github.com/onlynks/frontend-p7

If you don't use this frontend, please read the following instructions.

First, you need to install csa/guzzle-bundle in your application (composer require csa/guzzle-bundle/https://packagist.org/packages/csa/guzzle-bundle).

All the request you are going to send will require a token in the header of your request.
This Token is delivered by Facebook OAuth API.

```
<a href="https://www.facebook.com/v3.0/dialog/oauth?client_id="YourClientId*"&redirect_uri="YourUrl*">Get a code</a>
```
**YourClientId**: API's Facebook ID.


**YourUrl**: Url in your application that will process to the following code to treat the Facebook response.

Here is the code for a Symfony application:
```php
        $code = $request->query->get('code');

        $client = new Client(['base_uri'=>'(API path)/getToken']);
        $request = $client->request('GET', null, [
            'headers'=>[
                'code'=> $code,
                'url'=> '(Same Url as below: YourUrl)'
            ]
        ]);

        $apiResponse = json_decode($request->getBody()->getContents(), true);
        $token = $apiResponse['access_token'];
```

If you are register as User or Admin in the API you can proceed to the requests with this token.
exemple:

GET /Projet_7/phone HTTP/1.1

Host: API's host

X-AUTH-TOKEN: (your token)

## 4/Utilisation

Here is the list of the requests supported by the API to access the data.
All request require to be authenticated. To do this all request must be sent with a X-AUTH-TOKEN Header including your Facebook Token.

Base URI: {http://yourBasePath/}

#### User

| Operation              | Path          | Method  |
| -----------------------|:-------------:| -------:|
| Phone Details          | phone{id}     |   GET   |
| Phone List             | phone         |   GET   |
| Customer details       | customer{id}  |   GET   |
| Customer list          | customer      |   GET   |
| Add Customer           | customer      |   POST  |
| Update Customer        | customer{id}  |   PUT   |
| Delete Customer        | customer{id}  |  DELETE |

#### Admin

| Operation              | Path          | Method  |
| -----------------------|:-------------:| -------:|
| Add Phone              | phone         |   POST  |
| Update Phone           | phone{id}     |   PUT   |
| Delete Phone           | phone{id}     |  DELETE |

You have to use Json format for PUT and POST methods.

## Author

* **Nicolas Garnier**

