# Contact Management system
## _The backend using laravel and passport_

The system is design to manage your contacts in an organize manner

## what is required to runthe backend

- Database installed
- PHP 7+
- Composer
- And of couse laptop or machine 

## steps
- clone the repo  
```sh
$ git clone https://github.com/victorazangu/contact-manager-app-backend.git
```

- move inside the cloned directory  
```sh
$ cd contact-manager-app-backend
```

- then 
```sh
$ cp .env.example .env
```
- configure .env and connect to db

- install dependacy
```sh
$ composer install
```
- generate key
```sh
$ php artisan key:generate
```

- run migration 
```sh
$ php artisan migrate
```

- create encryption keys for passport 
```sh
$ php artisan passport:install
```

- run server
```sh
$ php artisan serve
```
# API Endpoints

## Authentication

### Register
- **Endpoint:** `/api/v1/register`
- **Method:** POST
- **Description:** Register a new user.
- **Request Body:** JSON object with user registration data.
- **Eg** 
```sh
{
	"name":"John Doe",
	"email":"john@gmail.com",
	"phone":"1234567890",
	"password":"password",
	"password_confirmation":"password"
}
```

### Login
- **Endpoint:** `/api/v1/login`
- **Method:** POST
- **Description:** Authenticate and log in a user.
- **Request Body:** JSON object with user login credentials.
- **Eg** 
```sh
{
	"email":"john@gmail.com",
	"password":"password",
}
```
### Logout
- **Endpoint:** `/api/v1/logout`
- **Method:** GET
- **Description:** Log out the currently authenticated user.

## User Profile

### Get User Profile
- **Endpoint:** `/api/v1/profile`
- **Method:** GET
- **Description:** Retrieve the user's profile information.

### Update User Profile Picture
- **Endpoint:** `/api/v1/profile/update-profile`
- **Method:** PUT
- **Description:** Update the user's profile picture.
- **Request Body:** Multipart form data with the new profile picture.

### Update User Profile data
- **Endpoint:** `/api/v1/profile`
- **Method:** PUT
- **Description:** Update the user's profile data.
- **Request Body:** Multipart form data with the new data.

## Contacts

### List Contacts
- **Endpoint:** `/api/v1/contacts`
- **Method:** GET
- **Description:** Retrieve a list of user contacts.

### Create Contact
- **Endpoint:** `/api/v1/contacts`
- **Method:** POST
- **Description:** Create a new contact.
- **Request Body:** JSON object with contact information.

### Show Contact
- **Endpoint:** `/api/v1/contacts/{contact}`
- **Method:** GET
- **Description:** Retrieve details of a specific contact.

### Update Contact
- **Endpoint:** `/api/v1/contacts/{contact}`
- **Method:** PUT
- **Description:** Update contact details.
- **Request Body:** JSON object with updated contact information.

### Delete Contact
- **Endpoint:** `/api/v1/contacts/{contact}`
- **Method:** DELETE
- **Description:** Delete a contact.

## Groups

### List Groups
- **Endpoint:** `/api/v1/groups`
- **Method:** GET
- **Description:** Retrieve a list of user groups.

### Create Group
- **Endpoint:** `/api/v1/groups`
- **Method:** POST
- **Description:** Create a new group.
- **Request Body:** JSON object with group information.

### Show Group
- **Endpoint:** `/api/v1/groups/{group}`
- **Method:** GET
- **Description:** Retrieve details of a specific group.

### Update Group
- **Endpoint:** `/api/v1/groups/{group}`
- **Method:** PUT
- **Description:** Update group details.
- **Request Body:** JSON object with updated group information.

### Delete Group
- **Endpoint:** `/api/v1/groups/{group}`
- **Method:** DELETE
- **Description:** Delete a group.

### Add Contact to Group
- **Endpoint:** `/api/v1/groups/{groupId}/add-contact/{contactId}`
- **Method:** POST
- **Description:** Add a contact to a group.

### Remove Contact from Group
- **Endpoint:** `/api/v1/groups/{groupId}/remove-contact/{contactId}`
- **Method:** DELETE
- **Description:** Remove a contact from a group.

## Update User Profile Picture

### Update User Profile Picture
- **Endpoint:** `/api/v1/update-profile-picture`
- **Method:** POST
- **Description:** Update the user's profile picture.
- **Request Body:** Multipart form data with the new profile picture.


