# steps to take the project

#### 1. setup docker environment and setup project with use of docker - DONE

 - php 8.1 for app +
 - postgres as database +
 - nginx as webserver +

#### 2. add a module system - DONE
- create a Modules folder +
- add composer.json and auto-discoverable service providers +
- config phpunit.xml to discover module's tests +
- add auth, truck, order module folders +

#### 3. add Auth module
- use laravel-sanctum for auth +
- register user +
- add role system +
- a command to create superuser of system +
- users can log in and see the dashboard page

#### 4. add Company management module
- superuser can create company with an admin user to it
- admin user can create trucks for company
- each truck is a combination of driver info and truck info


#### 4. add order module
- company admin can add client and locations for it
- company users can create order for client and attach client and truck for the order