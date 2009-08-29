<?php

/**
 * sfSqlDesignerPlugin actions.
 *
 * @package    sfSqlDesignerPlugin
 * @author     JP <jphpsf AT gmail DOT com>
 * @since      0.1
 */

class sfSqlDesignerPluginActions extends sfActions
{
  /**
   * main action to load the designer UI
   */
  public function executeDesigner()
  {
    $this->css_dir=sfConfig::get('sf_web_dir').'/sfSqlDesignerPlugin/css/';
    $this->images_dir=sfConfig::get('sf_web_dir').'/sfSqlDesignerPlugin/images/';
    $this->js_dir=sfConfig::get('sf_web_dir').'/sfSqlDesignerPlugin/js/';
  }

  /**
   * backend action for save/load from schema.yml
   */
  public function executeBackend($request)
  {
    // get ?action argument (save, load or import)
    $get=$request->getGetParameters();
    $action=(isset($get['action'])?$get['action']:FALSE);
    $this->logMessage("Backend called with $action",'info');

    // set response format
    $response=$this->getResponse();
    $response->setContentType('text/xml');

    switch ($action)
    {
      case "save":
      {
        try
        {
          // get file as sent
          $data = file_get_contents("php://input");

          // create yml file
          $ymlSchemaPath = sfConfig::get('sf_config_dir').'/doctrine/schema.yml';

          $this->logMessage('schema.yml: '.$ymlSchemaPath);

          $ymlSchema = fopen($ymlSchemaPath, "w");
          if (!$ymlSchema) throw new Exception("Can not create schema.yml file");

          // create DOM object and load the input data
          $xml=new DOMDocument();
          if (!$xml->loadXml($data)) throw new Exception("Can not load xml");

          $xslt = new XSLTProcessor();

          # import stylesheet
          $xsl = new DOMDocument();
          if (!$xsl->load(dirname(__FILE__).'/../../../web/db/symfony-doctrine/output.xsl')) throw new Exception("Can not load stylesheet");
          if (!$xslt->importStylesheet($xsl)) throw new Exception("Can not import stylesheet");

          # write to file
          $transform=$xslt->transformToXML($xml);
          if (!$transform) throw new Exception("XSLT transformation failed");
          if (!fwrite($ymlSchema,$transform)) throw new Exception("Can not write schema.yml file");
          if (!fclose($ymlSchema)) throw new Exception("Can not close schema.yml file");

          // all good! :)
          $response->setStatusCode(201);
          return $this->renderText("HTTP/1.0 201 Created");
        }
        catch (Exception $e)
        {
          if ($ymlFile)
          {
            fclose($ymlFile);
            unlink($keyword.".yml");
          }
          $response->setStatusCode(500);
          $this->logMessage('Error when saving: '.$e->getMessage());
          return $this->renderText("HTTP/1.0 500 Internal Server Error: ".$e->getMessage());
        }
        break;
      }

      case "load":
      {
        // here the code to convert schema.yml to xml
        $response->setStatusCode(501);
        return $this->renderText("HTTP/1.0 501 Not Implemented");
        break;
      }

      case "import":
      {
        // here the code to import from the DB
        $response->setStatusCode(501);
        return $this->renderText("HTTP/1.0 501 Not Implemented");
        break;
      }

      default:
      {
        $response->setStatusCode(501);
        return $this->renderText("HTTP/1.0 501 Not Implemented");
        break;
      }
    }
  }
}
