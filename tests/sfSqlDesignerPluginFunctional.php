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
  echo "Usage: php sfSqlDesignerTest.php frontend\n";
  exit(1);
}
$app=$argv[1];

// bootstrap
include(dirname(__FILE__).'/../../../test/bootstrap/functional.php');
$browser = new sfTestBrowser();
$browser->initialize();

// backup schema.yml and sfSqlDesignerPlugin.yml
$ymlPath=sfConfig::get('sf_config_dir').'/doctrine/schema.yml';
$xmlPath=sfConfig::get('sf_config_dir').'/doctrine/sfSqlDesignerPlugin.yml';

if (file_exists($ymlPath))
{
  copy($ymlPath,"$ymlPath.backup");
}
if (file_exists($xmlPath))
{
  copy($xmlPath,"$xmlPath.backup");
}

// test the controllers
$browser->
  get('/wwwSqlDesigner')->
  isStatusCode(200)->
  isRequestParameter('module', 'sfSqlDesignerPlugin')->
  isRequestParameter('action', 'designer')->
  checkResponseElement('body', '/WWW SQL Designer/')
;

// restore schema.yml and sfSqlDesignerPlugin.yml
if (file_exists("$ymlPath.backup"))
{
  copy("$ymlPath.backup",$ymlPath);
  unlink("$ymlPath.backup");
}
if (file_exists("$xmlPath.backup"))
{
  copy("$xmlPath.backup",$xmlPath);
  unlink("$xmlPath.backup");
}
