<?php


  /**
   * Class FileController
   *
   * Provide an api for users to get data about files
   */
  class FileController extends BaseController
  {
    /**
     * Return json encoded info about the incoming file
     *
     * @param string  $fileName
     */
    public function getIndex($fileName) {
      $fileDir = $_SERVER['DOCUMENT_ROOT'] . '/../videos';
      $file = $fileDir . '/' . $fileName;
      $comparisonRunner = new ComparisonRunner();
      $fileOutput = $comparisonRunner->getFileOutput($file);
      return Response::json($fileOutput);
    }

  }
