<?php

return array(
    // In case you do not define a theme in your controller,
    // or explicitly using Themify::setTheme(),
    // this one will be used.
    'default_theme' => 'default',

    // Internal folder where theme views are stored.
    // Defaults to (...)/app/themes
    'themes_path' => app_path() . '/themes',

    // The directory inside your public folder where all theme
    // assets are stored. If you changed your public folder in your
    // app config, it will be automatically detected.
    //
    // Do not include the public folder itself, or 
    // leading/trailing slashes.
    'themes_assets_path' => 'assets/themes',
);