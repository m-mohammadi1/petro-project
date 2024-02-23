#### build the project with
```
    make app.build
```

#### run the project with
```
    make app.run
```

#### restart the project with
```
    make app.restart
```

#### down the project with
```
    make app.down
```

**warn**: before running these commands configure your .env file in src/

use this endpoint to view the api docs
```
    /request-docs
```

1. [X] add unit tests for all the services
2. [ ] add integration tests for postgres repositories
3. [X] use business services in http layer (just some of them is used to show the mindset)
4. [ ] write end-to-end tests for http layer
5. [X] use form-requests and returned resources to generate api docs
6. [ ] create a basic react app
7. [X] add github hook to run tests and other stuff