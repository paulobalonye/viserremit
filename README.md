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

### Step 3: Configure Environment Variables in Digital Ocean

1. **Go to Digital Ocean App Platform Dashboard:**
   - Navigate to https://cloud.digitalocean.com/apps
   - Select your ViserRemit app

2. **Access App Settings:**
   - Click on your app name
   - Go to the "Settings" tab
   - Click on "App-Level Environment Variables"

3. **Add Required Environment Variables:**
   Click "Edit" and add these variables:

   **APP_KEY** (Required):
   - Generate locally: `cd core && php artisan key:generate --show`
   - Copy the output (format: base64:xxxxx)
   - In Digital Ocean: Key = `APP_KEY`, Value = the generated key
   - Mark as "Encrypted" ✓

   **Email Configuration** (Required for notifications):
   - Key = `MAIL_HOST`, Value = your SMTP server (e.g., smtp.gmail.com)
   - Key = `MAIL_USERNAME`, Value = your email address
   - Key = `MAIL_PASSWORD`, Value = your email password/app password
   - Mark all email variables as "Encrypted" ✓

   **Optional Production Variables:**
   - Payment gateway API keys
   - Third-party service credentials
   - Custom configuration values

### Step 4: Configure GitHub Repository Secrets

1. **Go to Your GitHub Repository:**
   - Navigate to https://github.com/yourusername/viserremit
   - Click on "Settings" tab
   - Click on "Secrets and variables" → "Actions"

2. **Add Digital Ocean Token:**
   - Click "New repository secret"
   - Name: `DIGITALOCEAN_ACCESS_TOKEN`
   - Value: Your Digital Ocean Personal Access Token
   - Get token from: https://cloud.digitalocean.com/account/api/tokens

### Step 5: Database Setup
The app will automatically create a MySQL database. After deployment:
1. Access the database console in Digital Ocean
2. Import the SQL dump from `install/database.sql`
3. Or run migrations: `php artisan migrate --seed`

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
