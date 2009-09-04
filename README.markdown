# sfSqlDesignerPlugin

## Introduction
Tired of hand writing your schema.yml to describe your database schema in Symfony? The sfSqlDesignerPlugin allows you to draw your schema tables using a drag and drop UI provided by [wwwsqldesigner](http://code.google.com/p/wwwsqldesigner/). Note: the plugin only supports Doctrine.

## Requirements
  * symfony 1.2.x
  * Doctrine

## Main Features
  * Save database schema from schema.yml
  * TODO: Load database schema from schema.yml
  * TODO: Import schema from database as configured in databases.yml
  * TODO: Support all options of Doctrine syntax for schema.yml
    * Not supported: actAsI18n, actAsGeographical, actAsSluggable, actAsSearchable, actAsNestedSet
    * Not supported: nested behaviors
    * Not supported: inheritance
    * Not supported: indexes

## Source
The plugin is available on github at http://github.com/jphpsf/sfSqlDesigner/tree/master , it is not available on Symfony plugins website (yet).

## Installation
  * In your Symfony project root directory, cd plugins/
  * Fetch a copy of the plugin with: `git clone git://github.com/jphpsf/sfSqlDesigner.git`
  * Publish assets (ignore this if you are upgrading): `symfony plugin:publish-assets`
  * Clear the cache `symfony cc`
  * Double check the plugin is enabled in config/ProjectConfiguration.class.php (should be as default in 1.2)
  * Open your app (or one of your app if you have several) config/settings.yml and add into the `dev:` section under the `.settings` section:

    `enabled_modules:`
      `- sfSqlDesignerPlugin`
  * Open your browser at http://url_of_your_app/yourapp_dev.php/wwwSqlDesigner

## Usage

TODO

## Tests

TODO

## Contribute
All contributions and suggestions are welcome.
