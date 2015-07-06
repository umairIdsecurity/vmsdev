# ID Security Kiosk App 

As part of the Visitor Management System (CVMS/AVMS) by Identity Security, the kiosk application allows visitors to check in and check out through a web-based kiosk interface. 

The check in process includes identification, photo capture, and notification to the visitor's host of their arrival. 
 
The application was developed using Angular, Bootstrap, and a JSON REST API to the Visitor Management System. 

# Deployment 

The application requires Google Chrome and was designed for the Microsoft Surface Pro 3 Tablet.  

The kiosk app can be deployed in a local implementation or SaaS model. In either situation, the kiosk app needs to be configured with the following: 

- Company-specific API Token (generated based on a company admin username and password) 
- Company-specific admin username / email address 
- Company specific profile (logo, colour scheme, etc) configured in VMS 
- API URL 

The above settings can be set in the vmsconfig.js file. 

# For Developers 

This project was generated with [yo angular generator](https://github.com/yeoman/generator-angular)
version 0.11.1.

## Build & development

Run `grunt` for building and `grunt serve` for preview.
 