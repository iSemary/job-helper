# **The “All In One CRM” for Job Seekers**

Ai not gonna take your job unless you start working with it! 🤖

Your job application will take less than 2 minutes using these features which will make your life much much easier. 🪄

Apply to your dream job with a powerful Cover Letter and a motivational message to impress recruiters to be on top of their candidates list.

## 🔑 Key Features:

-   Generate Cover Letters / Motivation Messages based on job description and your qualifications
-   Store and save your desired company dataset
-   Import Excel sheets with companies dataset
-   Reminder and follow up Emails
-   Kanban Board to organize companies applied to

🔐 Email credentials are fully encrypted with a secret hash key.

## Get Started

1. Register a new account
2. Fill Out your profile details
3. Update your email credentials
4. Add your companies dataset
5. Select the company you want to apply to, then:
    1. Generate cover letter file
    2. Generate motivation message
    3. One click to apply apply 📨
6. Organize companies using kanban board

## Installation

```bash
composer install
```

```bash
php artisan key:generate
```

```bash
php artisan migrate
```

```bash
php artisan queue:work
```

```bash
 php artisan serve 🚀
```

## 🐳 Docker is ready

### Not meeting your machine requirements? No Problem!

```bash
./vendor/bin/sail up
```

## How to get email credentials

To send emails from any web application, You have to get your email credentials from the service provider you use, for example:

-   Gmail
    -   Go to your Google Account.
    -   Select Security.
    -   Under "Signing in to Google," select 2-Step Verification.
    -   At the bottom of the page, select App passwords.
    -   Create new app
    -   Save the generated password
    -   Configuration
        -   Server name: [smtp.gmail.com](http://smtp.gmail.com/)
        -   Port: 587
        -   Encryption method: tls
-   Hotmail
    -   Configuration
        -   Server name: [smtp.office365.com](http://smtp.office365.com/)
        -   Port: 587
        -   Encryption method: STARTTLS

After you get your full configuration, Go to “Email Credentials” section and update your configuration.

## How to get OpenAi Token

https://platform.openai.com/account/api-keys

-   Create a new secret key or use any existing key
-   Save your key into “Profile Details” Section 3. On click apply 📨

6. Organize companies using kanban board
