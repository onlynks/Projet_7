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
All request require to be authenticated

Base URI: {http://yourBasePath/}

User:
  Phones:
    *Get a phone: phone/{id}              Method GET
    *Get the phone list: phone            Method GET
  Customers:
    *Get customer details: customer/{id}  Method GET
    *Get customer list: customer          Method GET
    *Add a customer: customer             Method POST
    *Update a customer: customer/{id}     Method PUT

Admin:
  Phones:
    *Create a phone: phone                Method POST
    *Update a phone: phone/{id}           Method PUT

You have to use Json format for PUT and POST methods.

## Author

* **Nicolas Garnier**

