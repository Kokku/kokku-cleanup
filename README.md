# Kokku Cleanup

A collection of cleanup, security & optimization modules to be applied to WordPress theme. From Developers to Developers with ❤️

## Modules

### Default
* **Cleanup**
`add_theme_support('kokku-cleanup');`

### Security
* **Disable Asset Versioning**
  `add_theme_support('kokku-disable-rest-api');`
* **Disable Trackbacks and Pingbacks**
`add_theme_support('kokku-disable-trackbacks');`

### Optimization
* **Disable emojis**
`add_theme_support('kokku-disable-emojis');`

* **Disable jQuery Migrate**
`add_theme_support('kokku-disable-jquery-migrate');`

* **Disable Wordpress REST Api**
`add_theme_support('kokku-disable-rest-api');`

* **Disable Wordpress RSS Feed**
`add_theme_support('kokku-disable-rss');`

* **Disable oEmbed**
  `add_theme_support('kokku-disable-oembed');`

## Installation

### Composer
```sh
composer require kokku/kokku-cleanup
```

### Admin Panel (.zip)
You can install this plugin via the WordPress Admin Panel.
1. Download the [latest zip](https://github.com/kokku/kokku-cleanup/releases/latest) of this repo.
2. In your WordPress Admin Panel, navigate to Plugins->Add New
3. Click Upload Plugin
4. Upload the zip file that you downloaded.
