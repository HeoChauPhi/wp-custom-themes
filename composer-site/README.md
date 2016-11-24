# starttheme
1. Import database in `sql` folder into phpmyadmin.
2. Copy `build\wp-config\wp-config.env.example.php` and change name to 'wp-config.local.php'
4. Config site in `build\wp-config\wp-config.local.php` file.
5. Download and extract `Wordpress Core` into `build` folder.
6. Move `custom-theme-composer` theme to `build\wp-content\themes\`.
7. Move `wp-config.php` in `build\wp-config` folder to `build` folder.
8. Run: `composer install`.
9. Create Vitual Host for project on local with curent folder `build`.
10. Run project with Vitual Host.