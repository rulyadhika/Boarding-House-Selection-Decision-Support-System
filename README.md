# Boarding House Selection Decision Support System
An application to help college student decision making when choosing a boarding house based on the criteria they want, with the help of the SAW (Simple Additive Weighting) Method.

## Installation

You can clone the repository with this command, or download this [zip](https://github.com/rulyadhika/Boarding-House-Selection-Decision-Support-System/archive/refs/heads/main.zip) file.

```bash
> git clone https://github.com/rulyadhika/Boarding-House-Selection-Decision-Support-System.git
```

## Configuration
1. Change terminal directory to Boarding-House-Selection-Decision-Support-System folder
```bash
> cd Boarding-House-Selection-Decision-Support-System
```

2. Run this command
```bash
> composer install
```

3. Duplicate .env.example file and rename it to .env . Or you can run this command
```bash
> copy .env.example .env
```

4. Generate app key with this command
```bash
> php artisan key:generate
```

5. Configure your app_url and database in .env file

6. Ensure your database is setup correctly, then run this command
```bash
> php artisan migrate:fresh --seed
```

7. Move src folder from public folder to storage/public folder using this command
```bash
> move public/src/ storage/app/public/
```

8. Create storage symbolic link using this command
```bash
> php artisan storage:link
```

9. Run local development server
```bash
> php artisan serve
```

## User credential for admin
* username : admin
* password : password