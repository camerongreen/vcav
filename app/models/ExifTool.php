<?php


  /**
   * Class ExifTool
   *
   * Runs the exiftool and returns information about the passed in filename
   */
  class ExifTool extends ToolBase
  {
    // todo: put into config
    //protected $command = '/usr/local/bin/exiftool -X';
    protected $command = '/usr/local/Cellar/exiftool/9.60/libexec/exiftool -X';

    /**
     * Xpath constants to access elements
     */
    const FILE_FORMAT = '//File:FileType';
    const FILE_FORMAT_PROFILE = '//QuickTime:MajorBrand';
    const FILE_SIZE = '//System:FileSize';
    const DURATION = '//QuickTime:Duration';
    const OVERALL_BITRATE = '//Composite:AvgBitrate';

    public function __construct($filename) {
      parent::__construct($filename);
    }

    public function parse() {
      $stringXml = $this->getRawOutput();
      $this->xml = new SimpleXmlElement($stringXml);
      $this->xml->registerXPathNamespace('rdf', 'http://www.w3.org/1999/02/22-rdf-syntax-ns#');
      $this->xml->registerXPathNamespace('File', 'http://ns.exiftool.ca/File/1.0/');
      $this->xml->registerXPathNamespace('QuickTime', 'http://ns.exiftool.ca/QuickTime/QuickTime/1.0/');
      $this->xml->registerXPathNamespace('System', 'http://ns.exiftool.ca/File/System/1.0/');
      $this->xml->registerXPathNamespace('Composite', 'http://ns.exiftool.ca/Composite/1.0/');
    }

    private function getSimple($xpath) {
      $result = $this->xml->xpath($xpath);

      // assume only first element matters
      return (string)$result[0];
    }

    function getFileFormat() {
      return $this->getSimple(self::FILE_FORMAT);
    }

    function getFileFormatProfile() {
      return $this->getSimple(self::FILE_FORMAT_PROFILE);
    }

    function getFileSize() {
      return $this->getSimple(self::FILE_SIZE);
    }

    function getDuration() {
      return $this->getSimple(self::DURATION);
    }

    function getOverallBitrate() {
      return $this->getSimple(self::OVERALL_BITRATE);
    }
  }
