#### Lumen framework API sample project
[1. Introduction](#introduction)

[2. REST API endpoints by user type](#rest-api-by-user-type)

[3. Database Schema](#database-schema)

[4. Installation](#installation)

[5. Dealing with authentication within Lumen framework](#authentication)

[6. Dependencies](#dependencies)

#### [1. Introduction](#introduction)
The API can access resources which relate to (1)  instructors, (2) students, (3) courses and (4) courses ratings by students.
#### [2. REST API endpoints by user type](#rest-api-by-user-type)
**(1/4) REST API endpoints available to any unauthenticated user**
|URI|Method|Description|
|------|------|------|
|/api/v1/instructors|GET|retrieves all instructors|
|/api/v1/students|GET|retrieves all students|
|/api/v1/courses|GET|retrieves all courses|
|/api/v1/instructors/stats|GET|retrieves all instructors related stats|
|/api/v1/instructors/:instructorId|GET|retrieves instructor with instructor id :instructorId|
|/api/v1/students/:studentId|GET|retrieves student with student id :studentId|
|/api/v1/courses/:courseId|GET|retrieves course with course id :courseId|
|/api/v1/instructors/:instructorId/stats|GET|retrieves stats of the instructor with instructor id :instructorId|


**(2/4) REST API endpoints available to any authenticated user with neither an instructor profile nor a student profile**
|URI|Method|Description|
|------|------|------|
|/api/v1/instructors/create|POST|creates a new instructor profile|
|/api/v1/students/create|POST|creates a new student profile|

> Note: An authenticated user can have either one instructor profile or one student profile (not both).  

**(3/4) REST API endpoints available to any authenticated user with an instructor profile**
|URI|Method|Description|
|------|------|------|
|/api/v1/instructors/update|PUT|lets the authenticated instructor update his/her instructor profile|
|/api/v1/instructors/delete|DELETE|lets the authenticated instructor delete his/her instructor profile|
|/api/v1/instructors/courses/create|POST|lets the authenticated instructor create a new course|
|/api/v1/instructors/courses/:courseId/update|PUT|lets the authenticated instructor update course with course id :courseId if he/she created it|
|/api/v1/instructors/courses/:courseId/delete|DELETE|lets the authenticated instructor delete course with course id :courseId if he/she created it|

**(4/4) REST API endpoints available to any authenticated user with a student profile**
|URI|Method|Description|
|------|------|------|
|/api/v1/students/update|PUT|lets the authenticated student update his/her student profile|
|/api/v1/students/delete|DELETE|lets the authenticated student delete his/her student profile|
|/api/v1/students/courses/:courseId/rating/create|POST|lets the authenticated student rate course with course id :courseId|

#### [3. Database Schema](#database-schema)

![Lumen API DB schema](https://github.com/KB-WEB-DEVELOPMENT/lumen-api/blob/main/lumen-api-db-schema.png)


#### [4. Installation](#installation)

##### 1. Clone the repository

`git clone https://github.com/KB-WEB-DEVELOPMENT/lumen-api.git`

##### 2. cd into the project

`cd lumen-api`

##### 3. Install composer dependencies

`composer install`

##### 4. Install NPM dependencies

`npm install`

##### 5. Copy the .env file

`cp .env.example .env`

##### 6. Generate an app encryption key

`php artisan key:generate`

##### 7. Create an empty database for the application

Create an empty database for your project using the database tools you prefer (phpmyadmin, datagrip, or any other mysql client).

#####  8. In the .env file, add the database information to allow Laravel to connect to the database

In the .env file, fill in the **DB_HOST**, **DB_PORT**, **DB_DATABASE**, **DB_USERNAME**, and **DB_PASSWORD** keys to match the credentials of the database you just created.

##### 9. Migrate the database

`php artisan migrate`

##### 10. Run seeders

Available seeders: UserSeeder, InstructorSeeder, StudentSeeder, CourseSeeder, CourseRatingSeeder, DatabaseSeeder.

You can either run (a) specific one(s) or all of them at once with:

`php artisan db:seed --class=DatabaseSeeder`

This will create 2 instructors, 2 students (4 authenticable users in total), 2 courses and one course rating for each course (2 courses ratings in total).

##### During Development
##### 11. Compile assets

`npm run dev`

`npm run watch`
##### 12. Local development serve

To run a local development server, you may run the following command. This will start a development server at **http://localhost:8000**

`php artisan serve`

##### [5. Dealing with authentication within Lumen framework](#authentication)

Lumen documentation on authentication is rather meagre but 
the two links below are enough:

https://lumen.laravel.com/docs/11.x/authentication

https://www.cloudways.com/blog/lumen-rest-api-authentication/

##### [6. Dependencies](#dependencies)


`vlucas/phpdoten`

`league/fractal`

`fzaninotto/fake`

`phpunit/phpunit`

`mockery/mockery`
