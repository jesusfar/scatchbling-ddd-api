# Scatchbling DDD API


This is a basic Restful API, inspired in concepts of Domain Driven Design.

This project was write in pure PHP for HTTP routing and controllers,
and it is inspired in modern PHP micro-frameworks.

### How to run:

#### With docker-compose:
Build images

```
$ docker-compose build

```

Up environment

```
$ docker-compose up -d

```

### For development
Install dependencies
```
$ composer install

```
Run tests
```
$ composer run tests:unit-test

```

### API Documentation:

You can find API raml documentation in doc folder ./doc/api/api.html

Or you can follow this link for postman documentation:

https://documenter.getpostman.com/view/2523140/scratcherapi/RVnQoNLo

### Demo endpoint:

You can test the api in:

http://ec2-18-216-251-218.us-east-2.compute.amazonaws.com:8081

Note: You need a valid authorization token for make requests..

Example request authorization:
```
curl -X POST \
  http://ec2-18-216-251-218.us-east-2.compute.amazonaws.com:8081/v1/authorization \
  -H 'content-type: application/json' \
  -d '{
	"user": "test",
	"password": "test"
}'
```

### TODOS
- Add support for PSR-7 
- Improve error handling
- Improve routing
- Add logs
- Add more unit test
- Add JWT authentication
- Add Oauth2 support
### Licence
MIT