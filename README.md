# ViserRemit - Digital Ocean Deployment

A Laravel-based remittance application deployed on Digital Ocean App Platform.

## Deployment Instructions

### Prerequisites
1. Digital Ocean account
2. GitHub repository
3. Digital Ocean Personal Access Token

### Step 1: Push to GitHub
```bash
git init
git add .
git commit -m "Initial commit"
git remote add origin https://github.com/yourusername/viserremit.git
git push -u origin main
```

### Step 2: Create Digital Ocean App
1. Go to Digital Ocean App Platform
2. Click "Create App"
3. Connect your GitHub repository
4. Select the repository containing this code
5. Choose the `main` branch
6. The app will automatically detect the `.do/app.yaml` configuration

### Step 3: Configure Environment Variables
In the Digital Ocean App Platform dashboard, add these environment variables:

**Required Secrets:**
- `APP_KEY`: Generate with `php artisan key:generate` (format: base64:...)
- `MAIL_HOST`: Your SMTP server
- `MAIL_USERNAME`: Your email username
- `MAIL_PASSWORD`: Your email password

**Optional (for production):**
- Payment gateway credentials
- Third-party API keys
- Custom configuration values

### Step 4: Database Setup
The app will automatically create a MySQL database. After deployment:
1. Access the database console
2. Import the SQL dump from `install/database.sql`
3. Or run migrations: `php artisan migrate --seed`

### Step 5: GitHub Actions Setup
Add this secret to your GitHub repository:
- `DIGITALOCEAN_ACCESS_TOKEN`: Your Digital Ocean API token

## Application Structure

```
├── .do/app.yaml              # Digital Ocean App Platform configuration
├── .github/workflows/        # GitHub Actions CI/CD
├── Dockerfile               # Container configuration
├── .docker/apache.conf      # Apache virtual host
├── core/                    # Laravel application
├── assets/                  # Frontend assets
└── install/                 # Installation files
```

## Features

- **Multi-currency remittance system**
- **Agent management**
- **KYC verification**
- **Payment gateway integrations**
- **Admin dashboard**
- **Real-time notifications**

## Tech Stack

- **Backend**: Laravel 11 (PHP 8.3+)
- **Database**: MySQL 8
- **Frontend**: Blade templates + Vite
- **Deployment**: Digital Ocean App Platform
- **CI/CD**: GitHub Actions

## Local Development

```bash
cd core
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run dev
php artisan serve
```

## Production Considerations

1. **Security**: All sensitive data is stored as secrets
2. **Performance**: Optimized with caching and asset compilation
3. **Scalability**: App Platform handles auto-scaling
4. **Monitoring**: Built-in logging and metrics
5. **SSL**: Automatic HTTPS certificates

## Support

For deployment issues, check:
1. Digital Ocean App Platform logs
2. GitHub Actions workflow results
3. Laravel application logs

## License

This application is proprietary software.
