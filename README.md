[:updated]: # "2021-12-30"

## simple-php-oop-email-api

Enhancements of previous php email-api

> Post formdata and send emails by using the built in mail function in PHP

[Code License: MIT](https://choosealicense.com/licenses/mit/)

| My Links: |                                                               |
| --------- | ------------------------------------------------------------- |
| WebPage:  | [leemann.se/fredrik](http://www.leemann.se/fredrik)           |
| YouTube:  | [youtube.com/FreLee54](https://www.youtube.com/user/FreLee54) |
| GitHub:   | [github.com/freddan88](https://github.com/freddan88)          |

### Tested with

- [PHP](https://www.php.net)
- [Apache](https://www.apache.org)
- [Insomnia](https://insomnia.rest)
- [Postman](https://www.postman.com)
- [Axios](https://www.npmjs.com/package/axios)

#### OBS! Only tested with web servers like Apache and PHP:s built in

> In order to send emails php.ini needs to be configured to use a mail-server or sendmail-program

### Links

- [How to Sendmail in PHP - Dibya Sahoo](https://pepipost.com/tutorials/sendmail-in-php-complete-guide)
- [PHP.NET: .INI Configuration for emails](https://www.php.net/manual/en/mail.configuration.php)
- [Send email from Localhost - phpBasics](https://www.youtube.com/watch?v=4_NP_WYFmIM&list=LLr-xGBx3NL3VGbdjDL4BuNw&index=2&t=0s)
- [Download sendmail for Windows](https://www.glob.com.au/sendmail)

### Installation

> Code located in the "api" directory

1. Clone or download this repository
2. Rename config_example.ini to ./api/config.ini
3. Configure "allowed_domains" in ./api/config.ini
4. Configure valid "api_key" in ./api/config.ini
5. Upload the api-folder to your webserver

##### Command to clone this repository:

```bash
git clone https://github.com/freddan88/simple-php-oop-email-api.git
```

### Generate keys here

- [Secure Password Generator](https://passwordsgenerator.net)
- [Secure Password & Keygen Generator](https://randomkeygen.com)

### Functionalities:

1. Security checks with api key and origin (domain)
2. Validation and sanitization of data sent from user
3. Error and success messages are sent back to client as json

### API endpoints

| Endpoint | Request Method | Description |
| -------- | -------------- | ----------- |
| /email   | POST           | Send email  |

### Multipart form-fields (Post)

| Field Name   | Field Value          | Required |
| ------------ | -------------------- | -------- |
| apikey       | Random string        | Yes      |
| emailTo      | Email to send to     | Yes      |
| senderEmail  | Email to send from   | Yes      |
| senderName   | Name of the sender   | No       |
| emailSubject | Subject of the email | Yes      |
| emailMessage | Message of the email | Yes      |
