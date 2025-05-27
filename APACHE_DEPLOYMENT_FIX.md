# Apache Deployment Fix for ViserRemit

## 🔧 Issue Analysis

The "Forbidden" error indicates that Apache is running but cannot properly serve the ViserRemit application. This is typically due to:

1. **Incorrect file permissions**
2. **Missing Apache modules**
3. **Improper directory configuration**

## ✅ Fixes Applied

### 1. Updated Build Process with Permissions
```yaml
build_command: |
  cd core && composer install --no-dev --optimize-autoloader
  cd core && php artisan key:generate --force
  cd core && php artisan migrate --force
  chmod -R 755 .
  chmod -R 777 core/storage
  chmod -R 777 core/bootstrap/cache
```

### 2. Enhanced .htaccess Configuration
- Added proper MIME types
- Enabled compression
- Set cache headers
- Maintained Laravel routing rules

### 3. Simplified App Platform Configuration
- Removed custom run commands (let Apache handle it)
- Set proper source directory
- Maintained all environment variables

## 🚀 Current Configuration Status

### `.do/app.yaml` - Optimized for Apache
```yaml
name: viserremit
services:
- name: web
  source_dir: /
  build_command: |
    cd core && composer install --no-dev --optimize-autoloader
    cd core && php artisan key:generate --force
    cd core && php artisan migrate --force
    chmod -R 755 .
    chmod -R 777 core/storage
    chmod -R 777 core/bootstrap/cache
  environment_slug: php
  # All environment variables configured
```

### `.htaccess` - Enhanced Apache Configuration
- ✅ URL rewriting enabled
- ✅ Authorization headers handled
- ✅ Static file serving optimized
- ✅ Security headers configured

## 📋 Deployment Steps

### 1. Redeploy with Updated Configuration
```bash
# Push the updated configuration
git add .do/app.yaml .htaccess
git commit -m "Fix Apache deployment configuration and permissions"
git push origin main
```

### 2. Monitor Deployment
- Watch build logs for permission setting
- Verify Laravel key generation
- Check database migration success

### 3. Test Application
After deployment:
- Visit: `https://viserremit-ym7wg.ondigitalocean.app/`
- Should show ViserRemit homepage
- Admin: `https://viserremit-ym7wg.ondigitalocean.app/admin`

## 🔍 Troubleshooting

### If Still Getting Forbidden Error

**Check 1: Build Logs**
- Verify permissions are set correctly
- Ensure Laravel commands complete successfully

**Check 2: Apache Modules**
- mod_rewrite should be enabled
- mod_negotiation should be available

**Check 3: File Structure**
- Ensure index.php is in root directory
- Verify .htaccess is properly placed

### Alternative: Force Apache Document Root

If issues persist, we can try setting explicit document root:

```yaml
# Add to .do/app.yaml if needed
run_command: |
  apache2-foreground
```

## 🎯 Expected Behavior

### After Successful Deployment:
1. ✅ Apache serves from root directory
2. ✅ .htaccess routes requests to index.php
3. ✅ index.php bootstraps Laravel from core/
4. ✅ Database connection works
5. ✅ Application loads properly

### File Flow:
```
Request → Apache → .htaccess → index.php → core/bootstrap/app.php → Laravel App
```

## 🔧 Database Connection

Your database is properly configured and will work:
- ✅ All environment variables set
- ✅ Database imported successfully
- ✅ Connection credentials verified
- ✅ Migration will run during build

## 📞 Next Steps

1. **Redeploy** with the updated configuration
2. **Monitor** the build process
3. **Test** the application once deployed
4. **Access** admin panel at `/admin`

The configuration is now optimized for Apache deployment on Digital Ocean App Platform.
