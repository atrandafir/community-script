INTRODUCTION
-------------------

[Community Script](https://communityscript.org/) is the platform that powers 
[CrazyPoems](https://crazypoems.org/) romanian community for poems enthusiasts and 
many other [communities](https://communityscript.org/network).

This is an Open Source software built with PHP and Yii 2 framework, among other tools.

The goal is to provide a platform with a feature set that will allow anyone to 
easily build an online community around content creation, such as: articles, 
poems, drawings, art, and any kind of content you can think of.

Features set:  

- Users & Profiles
- Posts
- Categories
- Comments & interactions
- Themeable & translatable
- Action-triggered web/mail notifications
- Mailing & newsletter
- Simple CMS
- Custom URL routing, friendly SEO URLs & sitemap generator
- Social network integration and broadcasting
- Contest system & other user engagement mechanisms
- Premium membership model & subscriptions
- Ads management
- Backoffice for configuring & moderating the platform

Example sites that can be built with it:  

- Wattpad like for writing stories
- Deviantart like for posting illustrations and art
- Instagram like for posting any content like a social media platform
- And with some extra customization, any other type of community, such as Soundcloud, Fans sites, etc

The platform can be used either for free configuring it yourself, or you can choose 
to subscribe and create a hosted instance that will run on our servers. (soon)

SITES POWERED BY CS
-------------------

https://crazypoems.org/

SETUP
-------------------

In order to set it up, please follow the [install](docs/guide/INSTALL.md) instructions 
or [sign up for a hosted](https://communityscript.org/hosted) version.

CREDITS & THANKS
-------------------

The development has been inspired by other Open Source tools such as 
https://presentator.io/ and https://www.humhub.com/en that have different purpose 
but are similar in terms of open source model.

<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Based on Yii 2 Advanced Project Template</h1>
    <br>
</p>

Yii 2 Advanced Project Template is a skeleton [Yii 2](http://www.yiiframework.com/) application best for
developing complex Web applications with multiple tiers.

The template includes three tiers: front end, back end, and console, each of which
is a separate Yii application.

The template is designed to work in a team development environment. It supports
deploying the application in different environments.

Documentation is at [docs/guide/README.md](https://github.com/yiisoft/yii2-app-advanced/blob/master/docs/guide/README.md).

DIRECTORY STRUCTURE
-------------------

```
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
    tests/               contains tests for common classes    
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for backend application    
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for frontend application
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
```

UNIT TESTING SETUP & COMMANDS
-------------------

General instructions can be read at the [Yii 2 Advanced Template testing guide](https://github.com/yiisoft/yii2-app-advanced/blob/master/docs/guide/start-testing.md).

Summarized tutorial:  

Create a new database suffixed with `_test`, example: `community_script_test`.

Setup config at `common/config/test-local.php`:  

```
return [
    // force english language on tests
    'language' => 'en-US',
    'components' => [
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => 'mysql:host=localhost;dbname=community_script_test',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
    ],
];
```

Run migrations:  

```
php yii_test migrate
```

Build test suite:  

```
php vendor/bin/codecept build
```

Run all tests:  

```
php vendor/bin/codecept run
```

Run only specific tests:  

```
// Test only frontend application by specifying config path
php vendor/bin/codecept -c frontend run

// Test a single class from the common directory
php vendor/bin/codecept -c common run unit models/LoginFormTest

// Test a single class and method from the common directory
php vendor/bin/codecept -c common run unit models/LoginFormTest:testLastLoginIsUpdated
```

### Common commands

## Translations

Run the following to extract messages: 

yii message common/config/messages.php