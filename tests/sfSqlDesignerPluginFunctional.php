<?php

/**
 * sfSqlDesignerPlugin functional tests.
 *
 * @package    sfSqlDesignerPlugin
 * @author     JP <jphpsf AT gmail DOT com>
 * @since      0.1
 */

// pass the app name
if (count($argv)!==2)
{
  echo "Usage: php sfSqlDesignerTest.php frontend";
  exit(1);
}
$app=$argv[1];

// bootstrap
include(dirname(__FILE__).'/../../../test/bootstrap/functional.php');
$browser = new sfTestBrowser();
$browser->initialize();

// backup schema.yml
$schema=sfConfig::get('sf_config_dir').'/doctrine/schema.yml';
if (file_exists($schema))
{
  copy($schema,"$schema.backup");
}

// test!
$browser->
  get('/wwwSqlDesigner')->
  isStatusCode(200)->
  isRequestParameter('module', 'sfSqlDesignerPlugin')->
  isRequestParameter('action', 'designer')->
  checkResponseElement('body', '/WWW SQL Designer/')
;

// restore schema.yml
if (file_exists("$schema.backup"))
{
  copy("$schema.backup",$schema);
  unlink("$schema.backup");
}
