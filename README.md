# VGreen Application - Vblog Module

## Installation
```bash
composer require willvrd/vblog-module
```
   
## Steps

    1.  Run migration:
```bash
php artisan module:migrate Vblog
```
    2. Run this command: 
```bash
php artisan vblog:init
```
    3. Run NPM
```bash
npm run dev
```

## End Points

Route Base: `https://yourhost.com/api/vblog/v1/`

* #### Post

* #### Category   

## Backend

    ### Pages
    
        Index:  http://mysite/backend/vblog/posts
        name:    admin.vblog.posts.index

        Index:  http://mysite/backend/vblog/categories
        name:    admin.vblog.categories.index


