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

    // doctrine config directory
    $ymlPath=sfConfig::get('sf_config_dir').'/doctrine/schema.yml';
    $xmlPath=sfConfig::get('sf_config_dir').'/doctrine/sfSqlDesignerPlugin.xml';

    switch ($action)
    {
      case "save":
      {
        try
        {
          $xml=file_get_contents("php://input");

          // attempt to save to schema.yml
          sfSqlDesignerLib::saveToSchema($xml,$ymlPath);

          // attempt to save to sfSqlDesignerPlugin.xml
          if (!file_put_contents($xmlPath,$xml)) throw new Exception('Could not save to sfSqlDesignerPlugin.xml');

          // all good! :)
          $response->setStatusCode(201);
          return $this->renderText("HTTP/1.0 201 Created");
        }
        catch (Exception $e)
        {
          $response->setStatusCode(500);
          $this->logMessage('Error when saving: '.$e->getMessage());
          return $this->renderText("HTTP/1.0 500 Internal Server Error: ".$e->getMessage());
        }
        break;
      }

      case "load":
      {
        try
        {
          // first try to load the sfSqlDesignerPlugin.xml file we previously saved, there
          // is no need to do the conversion work again
          if (file_exists($xmlPath))
          {
            $xml=file_get_contents($xmlPath);
          }
          else if (file_exists($ymlPath)) // next we try the schema.yml
          {
            //here the code to convert schema.yml to xml
            //$xml=....
            $response->setStatusCode(501);
            return $this->renderText("HTTP/1.0 501 Not Implemented");
          }
          else
          {
            throw new Exception('No schema file found');
          }

          $response->setContentType('text/xml');
          return $this->renderText($xml);
        }
        catch (Exception $e)
        {
          $response->setStatusCode(500);
          $this->logMessage('Error when loading: '.$e->getMessage());
          return $this->renderText("HTTP/1.0 500 Internal Server Error: ".$e->getMessage());
        }
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
