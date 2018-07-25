# Project 7: Create a web service exposing an API

I was charged to develop an API REST for the society BileMo wich is a phone seller.
The goal of the project is to set accessible a platform where BileMo can propose their phones to others companies and control the custumer administration. 

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

* Composer
* Database
* Server PHP
* Facebook App (refer to this tutorial if you don't knw how to get it: https://www.nukesuite.com/fr/support/social-applications/creating-application-from-facebook-developers/)

### Installing

* Clone the project in your repository.
* Run a composer update
* Fill the field during the installation (Database host, Database password, API key...)

That's it!

## Utilisation

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

