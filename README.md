# Mentor Management

## About this project

This project is a lightweight CRM to help teachers to manage their students, subjects, customers, courses and invoices.

This web application has the following features

## Main dashboard
The main dashboard show the datas about : 

- The total number of courses you did
- The students count
- The total revenue of every course you did
- The total of course hours you gave 

## Students management
You can manage all your students by adding, editing ou deleting one or more student.

When you create a new student you must provide, the subject he wants to learn, and the customer who he belongs.

After that the most important thing is to describe the main purposes of the student.

## Customers management
Into this menu you can manage the customers of each student by adding, editing or deleting them.

## Subjects management
Into this menu you can manage the subjects by adding, editing or deleting the subjects. 

One student can be assigned to one subject, and one subject can be assigned to many students.

## Courses management
Into this menu, you can manage every course by adding, editing them.

You can add a course by specifing the date of the course, the start hour, the end hour (the hours duration is calculated automatically).

For each course, you must provide the topics of the course, the hourly rate and the main invoice it belongs to.

## Invoices management
Into this menu, you can manage every course by adding, editing the invoices.

Each invoice is linked to many course, and you can display the details of an invoice.

It allows to have the number of courses linked to this invoice and the total of revenues.

## Technologies 
This project was made with the PHP framework Laravel.

The testing part has been made with PHPUnit

## Contributing
Thank you for considering contributing to this project ! 

To contribute to this project please follow these steps : 
1. Clone this repository
2. Run these commands : 
* `composer install`
* `npm install && npm run dev`
* `php artisan migrate:fresh --seed`
* `php artisan test`

## License

This project is an open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
