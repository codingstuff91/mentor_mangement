# Mentor Management

## About this project

This project is a lightweight CRM that helps teachers who provides personnal courses to manage their students, subjects, customers, courses and invoices.

This web application has the following features

## Main dashboard
The purpose of this menu is to show the datas about : 

- The total number of courses you did
- The total students count to manage
- The total revenue of every course you did
- The total of course hours you gave 

## Students management
You can manage all your students by adding, editing ou deleting one or more student.

One student must be linked to one subject and customer.

When you create a new student you also must provide, the subject he wants to learn, and the customer who he belongs.

You can have the full details of the courses you gave to a specific student, and for each course you can see what topics are about.

After that the most important thing is to describe the purposes of the student (learn PHP, Improve Excel skills, etc...)

## Customers management
Into this menu you can manage the customers of each student by adding, editing or deleting them.

## Subjects management
Into this menu you can manage the subjects by adding, editing or deleting the subjects. 

One student can be assigned to one subject, and one subject can be assigned to many students.

## Courses management
Into this menu, you can manage every course by adding, editing them.

You can add a course by specifing the date of the course, the start hour, the end hour (the hours duration is calculated automatically).

NB : Each course must be linked to an invoice. If the invoice doesn't exists, you have to create if first.

For each course, you must provide the topics of the course, the hourly rate and the main invoice it belongs to.

## Invoices management
Into this menu, you can manage every course by adding, editing the invoices.

For each invoice the Month and the Year is automaticaly provided.

Each invoice is linked only one customer and many courses, and you can display the details of an invoice.

It allows to have the number of courses linked to this invoice and the total of revenues.

## Technologies 
This project was made with the PHP framework Laravel.

The testing part has been made with PHPUnit

## Installation
This web application is open source.

If you want to use this project please follow these steps : 
1. Clone this repository
2. Run these commands : 
* `composer install`
* `npm install && npm run dev`
* `php artisan migrate:fresh --seed`

NB : if you don't want some example data, you must execute the last command wihout the --seed flag.

## License

This project is an open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
