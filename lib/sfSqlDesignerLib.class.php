<?php

/**
 * sfSqlDesignerPlugin conversion library.
 *
 * @package    sfSqlDesignerPlugin
 * @author     JP <jphpsf AT gmail DOT com>
 * @since      0.1
 */

class sfSqlDesignerLib
{
  /**
   * Convert provided database description in XML to YML schema file.
   *
   * @param $xml The XML database description
   * @param $schemaPath The path to the schema.yml file
   * @throw Exception on error
   */
  static public function saveToSchema($xml,$schemaPath)
  {
    if (!extension_loaded('dom')) throw new Exception("dom extension is missing");
    $dom=new DOMDocument();
    if (!$dom->loadXml($xml)) throw new Exception("Can not load xml");

    if (!extension_loaded('xsl')) throw new Exception("xsl extension is missing");
    $xslt=new XSLTProcessor();

    $xsl=new DOMDocument();
    $stylesheet=dirname(__FILE__).'/../web/db/symfony-doctrine/output.xsl';
    if (!$xsl->load($stylesheet)) throw new Exception("Can not load stylesheet");
    if (!$xslt->importStylesheet($xsl)) throw new Exception("Can not import stylesheet");
    $transform=$xslt->transformToXML($dom);
    if (!$transform) throw new Exception("XSLT transformation failed");

    $ymlSchema = fopen($schemaPath, "w");
    if (!$ymlSchema) throw new Exception("Can not open schema.yml file");
    if (!fwrite($ymlSchema,$transform))
    {
      fclose($ymlSchema);
      throw new Exception("Can not write schema.yml file");
    }
    if (!fclose($ymlSchema)) throw new Exception("Can not close schema.yml file");
  }

  /**
   * Convert the schema.yml file to a database description in XML.
   *
   * @param $schemaPath The path to the schema.yml file
   * @return XML database description
   * @throw Exception on error
   */
  static public function loadFromSchema($schemaPath)
  {


  }

  static public function importFromDb()
  {
  }
}
