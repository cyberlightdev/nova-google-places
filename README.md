# nova-google-places
A Laravel Nova Field to Autocomplete Addresses with the Google Places API

# WHY
The Algolia Places API is being removed soon and the existing nova field implementations of Google's Places Autocomplete do not function in Nova v4. I needed address verification for an app that I was building with Nova 4, so here we are!

# NOTE: This is a WIP! 
...and potentially not suitable for production.  I created this primarily to meet my own need, but I welcome pull requests and improvements.

# Installation
I honestly expect the Nova team will come out with a first-party Algolia replacement before long, so this repo is not available on packagist for now.  In the meantime, you can bring this into composer directly from git with a quick edit to your composer.json file.

```json
"repositories": [
        {
            "type": "composer",
            "url": "https://nova.laravel.com"
        },
        {
            "type": "vcs",
            "url": "https://github.com/mknooihuisen/nova-google-places"
        }
],
"require": {
  "laravel/nova": "~4.0",
  "mknooihuisen/nova-google-places": "dev-main",
  ...
}
```
