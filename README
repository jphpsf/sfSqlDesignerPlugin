# sfSqlDesignerPlugin

## Introduction
Tired of hand writing your schema.yml to describe your database schema in Symfony? The sfSqlDesignerPlugin allows you to draw your schema tables using a drag and drop UI provided by [wwwsqldesigner](http://code.google.com/p/wwwsqldesigner/). Note: the plugin only supports Doctrine.

## Requirements
  * symfony 1.2.x
  * Doctrine

## Main Features
  * Save database schema to schema.yml and sfSqlDesigner.xml
  * Load database schema from sfSqlDesigner.xml
  * TODO: Load database schema from schema.yml (issues to resolve: restore x/y position and comments)
  * TODO: Proper support for behaviors and table options (ie: not using a datatype hack)
  * TODO: Import schema from database as configured in databases.yml
  * TODO: Support all options of Doctrine syntax for schema.yml
    * Not supported yet: actAsI18n, actAsGeographical, actAsSluggable, actAsSearchable, actAsNestedSet
    * Not supported yet: nested behaviors
    * Not supported yet: inheritance
    * Not supported yet: indexes
    * Not supported yet: one to many and many to many relationships, delete cascade
  * TODO: Support translations of wwwsqldesigner for added UI elements
  * TODO: Add global schema information
  * TODO: Add link to sql designer in debug bar?
  * TODO: Add a button to call the doctrine build task to make sure the generated model is valid?

## Source
The plugin is available on github at http://github.com/jphpsf/sfSqlDesigner/tree/master , it is not available on Symfony plugins website (yet).

## Installation
  * Cd in your Symfony project root directory
  * Fetch a copy of the plugin with:
        $> git clone git://github.com/jphpsf/sfSqlDesigner.git plugins/sfSqlDesignerPlugin
  * Clear the cache:
        $> symfony cc
  * Ignore the following steps if you are upgrading:
    * Publish assets:
          $> symfony plugin:publish-assets
    * Double check the plugin is enabled in config/ProjectConfiguration.class.php (should be as default in 1.2)
    * Open your app (or one of your app if you have several) config/settings.yml and add in the "dev:" section like this:
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

  * Open your browser at http://url_of_your_app/yourapp_dev.php/wwwSqlDesigner
  * Use the toolbox on the right of the screen to add tables/fields/keys...
  * When ready, use the save/load dialog to save to schema.yml
    * Note 1: the plugin will save to schema.yml in your doctrine config directory as well as the schema xml source in the file sfSqlDesignerPlugin.xml
    * Note 2: current version of the plugin does not support loading from schema.yml
    * Note 3: any manual change in schema.yml will be overwritten by the next save action in the designer
  * Next time you open the designer, the schema should automatically load from the sfSqlDesignerPlugin.xml file

## Tests

  * To run the tests, enable the plugin module in the "test:" section of your app config/settings.yml
  * Then in the plugin directory execute:
        $> tests/sfSqlDesignerPluginFunctional.php yourapp
        $> tests/sfSqlDesignerPluginUnit.php

## Contribute
All contributions and suggestions are welcome.
