<?php

  /**
   * Class ComparisonRunner
   *
   * Run comparisons of various media info gathering libraries and
   * return the results
   */
  class ComparisonRunner
  {
    /**
     *
     * Top level function, takes the files, and runs the tools
     *
     * @param string $fileName
     * @return mixed
     */
    public function getFileOutput($fileName) {
      if (!file_exists($fileName)) {
        throw new Exception("File doesn't exist: " . $fileName);
      } else {
        $ffprobe = new FfProbe($fileName);
        $ffprobe->parse();

        $exifTool = new ExifTool($fileName);
        $exifTool->parse();

        $mediaInfo = new MediaInfo($fileName);
        $mediaInfo->parse();

        $tools = array(
            'FFProbe' => $ffprobe,
            'ExifTool' => $exifTool,
            'MediaInfo' => $mediaInfo,
        );

        return $this->runComparisons($tools);
      }
    }

    /**
     * Run an individual set of tests using the passed in tools
     *
     * @param array $tools
     * @param string  $function
     * @return array $output
     */
    protected function runComparison($tools, $function) {
      $returnVal = array();
      foreach ($tools as $tool => $toolInstance) {
        try {
          if (method_exists($toolInstance, $function)) {
            $result = $toolInstance->$function();
            $returnVal[$tool] = $result;
          } else {
            $returnVal[$tool] = 'N/A';
          }
        } catch (Exception $e) {
          // todo: something better
          $returnVal[$tool] = 'N/P';
        }
      }

      return $returnVal;
    }

    /**
     * Run all the comparisons for the passed in tools
     *
     * @param $tools  array of tools to try
     * @return  multi dimensional array of results
     */
    protected function runComparisons($tools) {
      $comparisons = array(
          "Container" => array(
              "File Format" => "getFileFormat",
              "File Format Profile" => "getFileFormatProfile",
              "File Size" => "getFileSize",
              "Duration" => "getDuration",
              "Overall Bitrate" => "getOverallBitrate",
          ),
          "Video Track" => array(
              "Codec" => "getCodec",
              "Codec ID" => "getCodecId",
              "Codec Profile" => "getCodecProfile",
              "Display Aspect Ratio" => "getDisplayAspectRatio",
              "Frame Rate" => "getFrameRate",
          ),
          "Audio Track" => array(
              "Codec" => "getAudioCodec",
              "Codec ID" => "getAudioCodecId",
              "Sampling Rate" => "getAudioSamplingRate",
          )
      );

      $returnVal = array();

      foreach ($comparisons as $title => $reports) {
        $returnVal[$title] = array();
        foreach ($reports as $header => $function) {
          $returnVal[$title][$header] = $this->runComparison($tools, $function);
        }
      }

      return $returnVal;
    }
  }
