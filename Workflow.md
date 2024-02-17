# steps to take the project

#### 1. setup docker environment and setup project with use of docker

 - php 8.1 for app
 - postgres as database
 - nginx as webserver

#### 2. add a module system
- create a Modules folder
- create a shared module
- add composer.json and auto-discoverable service providers
- config phpunit.xml to discover module's tests


#### 3. add Auth module
- a command to create superuser of system
- superuser can create company with an admin user
- admin user can create multiple users with defined roles
- each user can have access to different modules by the role
- users can login and see the dashboard page

#### 4. add truck management module
- admin can create trucks for company
- each truck is a combination of driver info and truck info


#### 4. add order module
- company admin can add client and locations for it
- company users can create order for client and attach client and truck for the order