<?php

class ComparisonRunner {
  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function getFileOutput($file) {
    if (!file_exists($file)) {
      throw new Exception("File doesn't exist: " . $file);
    } else {
      $ffprobe = new FfProbe($file);
      $ffprobe->parse();

      $exifTool = new ExifTool($file);
      $exifTool->parse();

      $mediaInfo = new MediaInfo($file);
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
   * Compare file format Profiles
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
   * Compare elements
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
