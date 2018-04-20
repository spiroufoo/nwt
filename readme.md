# PHP Developer Assignment

Project to compare two github repositories

## Relevant files

* app/Http/Controllers/GithubController.php
* public/js/nwt.js
* resources/views/nwt.php
* routes/web.php

## Rest API

### Schema

All API access is over HTTP, and accessed from [Rest API](http://nwt.upcor.se/public/api). All data is sent and received as JSON.

### Compare GitHub repositories

Compares two GitHub repositories with eachother

GET /compare/:owner1/:repo1/:owner2/:repo2

#### Response

```javascript
{  
   "repo1":{ // first repository to compare
      "full_name":"asciinema\/asciinema", // first repository name
      "forks_count":489, // first repository forks
      "stargazers_count":5475, // first repository stars
      "watchers_count":5475, // first repository watchers
      "subscribers_count":279, // first repository subscribers
      "pushed_at":"2018-04-09 06:57", // first repository last push
      "open_pulls":3, // first repository open pull requests
      "closed_pulls":0 // first repository closed pull requests
   },
   "repo2":{ // second repository to compare
      "full_name":"photonstorm\/phaser", // second repository name
      "forks_count":5503, // second repository forks
      "stargazers_count":21198, // second repository stars
      "watchers_count":21198, // second repository watchers
      "subscribers_count":1310, // second repository subscribers
      "pushed_at":"2018-04-19 21:47", // second repository last push
      "open_pulls":7, // second repository open pull requests
      "closed_pulls":0 // second repository closed pull requests
   },
   "comparison":{
      "repo1_popularity":5754, // first repository stars + subscribers
      "repo1_activity":"9%", // first repository inverse of total days since last push
      "repo1_size":1752, // first repository size
      "repo2_popularity":22508, // second repository stars + subscribers
      "repo2_activity":"100%", // second repository inverse of total days since last push
      "repo2_size":269078, // second repository size
      "diff_popularity":"391%", // second repository popularity compared to first
      "diff_activity":"1100%", // second repository activity compared to first
      "diff_size":"15358%" // second repository size compared to first
   }
}
```

## Lumen PHP Framework

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://poser.pugx.org/laravel/lumen-framework/d/total.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/lumen-framework/v/stable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/lumen-framework/v/unstable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://poser.pugx.org/laravel/lumen-framework/license.svg)](https://packagist.org/packages/laravel/lumen-framework)

Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.

## Official Documentation

Documentation for the framework can be found on the [Lumen website](http://lumen.laravel.com/docs).

## License

The Lumen framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
