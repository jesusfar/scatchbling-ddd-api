# Scatchbling API


This is a basic Restful API, inspired in concepts of Domain Driven Design.

This project was write in pure php for http routing and controllers,
and it is inspired in modern php micro-frameworks.

### How to run:

#### With docker-compose:
Build images

```
$ docker-compose build

```

Up environment

```
$ docker-compose build

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

Note: You need a valid authorization token.

```
curl -X POST \
  http://ec2-18-216-251-218.us-east-2.compute.amazonaws.com:8080/v1/authorization \
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