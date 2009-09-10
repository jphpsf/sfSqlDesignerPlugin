<?php

/**
 * sfSqlDesignerPlugin unit tests.
 *
 * @package    sfSqlDesignerPlugin
 * @author     JP <jphpsf AT gmail DOT com>
 * @since      0.1
 */

// initialize the test object
include(dirname(__FILE__).'/../../../test/bootstrap/unit.php');
$t = new lime_test(3, new lime_output_color());

// this test the converter from xml to yml only
/*try
{
	$xml=file_get_contents(dirname(__FILE__).'/books.xml');
	sfSqlDesignerLib::saveToSchema($xml,'/tmp/test.yml');
	$result=file_get_contents('/tmp/test.yml');
	unlink('/tmp/test.yml');
	$t->cmp_ok($result,'===',$yml,'generated yml is as expected');
}
catch (Exception $e)
{
	$t->fail('failed to convert xml to yml, error was: '.$e->getMessage());
}*/

// this test the converter from yml to xml and regenerate the yml to match
// the original. this way, no need to do a comparison on the xml (which can
// slightly differ)
try
{
	$xml=sfSqlDesignerLib::loadFromSchema(dirname(__FILE__).'/books.yml');
	if (!$xml) throw new Exception('empty xml in return');
}
catch (Exception $e)
{
	$t->fail('failed to convert xml to yml, error was: '.$e->getMessage());
}

$xmlHeader='/^<\?xml version="1.0" encoding="utf-8" \?>\n<sql>\n<datatypes db="symfony-doctrine">/';
$t->like($xml,$xmlHeader,'xml as a proper header');
$xmlFooter='/<\/table>\n<\/sql>/';
$t->like($xml,$xmlFooter,'xml as a proper footer');

try
{
	sfSqlDesignerLib::saveToSchema($xml,'/tmp/test.yml');
	if (!file_exists('/tmp/test.yml')) throw new Exception('yml file as not been saved to disk');
}
catch (Exception $e)
{
	$t->fail('failed to convert xml to yml, error was: '.$e->getMessage());
}

$result=file_get_contents('/tmp/test.yml');
unlink('/tmp/test.yml');
$books=file_get_contents(dirname(__FILE__).'/books.yml');
$t->cmp_ok($result,'===',$books,'generated xml was as expected and yml generated as original');


?>
