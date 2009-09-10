# sfSqlDesignerPlugin

## Introduction
Tired of hand writing your schema.yml to describe your database schema in Symfony? The sfSqlDesignerPlugin allows you to draw your schema tables using a drag and drop UI provided by [wwwsqldesigner](http://code.google.com/p/wwwsqldesigner/). Note: the plugin only supports Doctrine.

## Requirements
  * symfony 1.2.x
  * Doctrine

## Main Features
  * Save database schema to schema.yml
  * TODO: Load database schema from schema.yml
  * TODO: Import schema from database as configured in databases.yml
  * TODO: Support all options of Doctrine syntax for schema.yml
    * Not supported yet: actAsI18n, actAsGeographical, actAsSluggable, actAsSearchable, actAsNestedSet
    * Not supported yet: nested behaviors
    * Not supported yet: inheritance
    * Not supported yet: indexes
    * Not supported yet: one to many and many to many relationships, delete cascade


## Source
The plugin is available on github at http://github.com/jphpsf/sfSqlDesigner/tree/master , it is not available on Symfony plugins website (yet).

## Installation
  * Cd in your Symfony project root directory
  * Fetch a copy of the plugin with: `git clone git://github.com/jphpsf/sfSqlDesigner.git plugins/sfSqlDesignerPlugin`
  * Clear the cache `symfony cc`
  * Ignore the following steps if you are upgrading:
    * Publish assets: `symfony plugin:publish-assets`
    * Double check the plugin is enabled in config/ProjectConfiguration.class.php (should be as default in 1.2)
    * Open your app (or one of your app if you have several) config/settings.yml and add into the `dev:` like this:

    dev:
      .settings:
        error_reporting:        <?php echo (E_ALL | E_STRICT)."\n" ?>
        web_debug:              on
        cache:                  off
        no_script_name:         off
        etag:                   off
        enabled_modules:
          - sfSqlDesignerPlugin

  * Open your browser at http://url_of_your_app/yourapp_dev.php/wwwSqlDesigner

## Usage

TODO

## Tests

TODO

## Contribute
All contributions and suggestions are welcome.
