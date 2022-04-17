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

# Usage
Usage is very simple right now, though I may add more features down the road.  Let's say you wanted your User model to have an optional address...

First, make an appropriate migration
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->json('home_address')->nullable(); //named as you like, of course.
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('home_address');
        });
    }
};
```

next make sure your User model knows how to handle it.
```php
namespace App\Models;

protected $fillable = [
        ...
        'home_address',
        ...
];

protected $casts = [
        ...
        'home_address' => 'json',
        ...
];
```

and finally, make use of it in your Nova User Resource!
```php
use use Mknooihuisen\GooglePlaces\GooglePlaces;

class User extends Resource {
        
        ...
        public function fields(NovaRequest $request) {
                return [
                        ...
                        GooglePlaces::make("Home Address", 'home_address');
                        ...
                ];
        }
}
```

# Todo:
If this winds up being a permanent package, there are a number of enhancements I want to make:
- Currently the field only handles US addresses well, this should be customizable.
- Localization options for non-English speakers
- Ability to edit the field without expanding the address into it's components first.

Also, there are many caases when we might want more than one address per record.  Vacation homes, business addresses, etc. One option might be graduating this to a full installable Model and Trait combo, to make adding addresses wherever needed easy.
