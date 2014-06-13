<?php

  class FfProbe extends ToolBase
  {
    protected $command = '/usr/local/bin/ffprobe -show_format -show_streams -show_data -show_error -show_versions -print_format xml';

    /**
     * Xpath constants to access elements
     */
    const FORMAT_BASE = '//format';
    const STREAM_BASE = '//stream';
    const AUDIO_CODEC_BASE = '//stream';
    const FILE_FORMAT = 'format_name';
    const FILE_FORMAT_PROFILE = 'format_long_name';
    const FILE_SIZE = 'size';
    const DURATION = 'duration';
    const OVERALL_BITRATE = 'bit_rate';
    const CODEC_CHECK = '//stream[@codec_type="video"]';
    const CODEC = 'codec_name';
    const CODEC_ID = 'codec_tag_string';
    const CODEC_PROFILE = 'profile';
    const FRAME_RATE = 'r_frame_rate';
    const AUDIO_CODEC_CHECK = '//stream[@codec_type="audio"]';
    const AUDIO_CODEC = 'codec_name';
    const AUDIO_CODEC_ID = 'codec_tag_string';
    const AUDIO_SAMPLING_RATE = 'sample_rate';

    public function __construct($filename) {
      parent::__construct($filename);
    }

    public function parse() {
      $stringXml = $this->getRawOutput();
      $this->xml = new SimpleXmlElement($stringXml);
    }

    private function getSimple($xpathRoot, $attribute) {
      $result = $this->xml->xpath($xpathRoot);

      // assume only first element matters
      $attributes = $result[0]->attributes();

      return (string)$attributes[$attribute];
    }

    private function getCheck($check, $xpathRoot, $attribute) {
      $checkResult = $this->xml->xpath($check);

      if ($checkResult) {
        return $this->getSimple($xpathRoot, $attribute);
      } else {
        throw new Exception("Not available");
      }
    }

    function getFileFormat() {
      return $this->getSimple(self::FORMAT_BASE, self::FILE_FORMAT);
    }

    function getFileFormatProfile() {
      return $this->getSimple(self::FORMAT_BASE, self::FILE_FORMAT_PROFILE);
    }

    function getFileSize() {
      return $this->getSimple(self::FORMAT_BASE, self::FILE_SIZE);
    }

    function getDuration() {
      return $this->getSimple(self::FORMAT_BASE, self::DURATION);
    }

    function getOverallBItrate() {
      return $this->getSimple(self::FORMAT_BASE, self::OVERALL_BITRATE);
    }

    function getFrameRate() {
      return $this->getSimple(self::STREAM_BASE, self::FRAME_RATE);
    }

    function getCodec() {
      return $this->getCheck(self::CODEC_CHECK, self::STREAM_BASE, self::CODEC);
    }

    function getCodecId() {
      return $this->getCheck(self::CODEC_CHECK, self::STREAM_BASE, self::CODEC_ID);
    }

    function getCodecProfile() {
      return $this->getCheck(self::CODEC_CHECK, self::STREAM_BASE, self::CODEC_PROFILE);
    }

    function getAudioCodec() {
      return $this->getCheck(self::AUDIO_CODEC_CHECK, self::AUDIO_CODEC_CHECK, self::AUDIO_CODEC);
    }

    function getAudioSamplingRate() {
      return $this->getCheck(self::AUDIO_CODEC_CHECK, self::AUDIO_CODEC_CHECK, self::AUDIO_SAMPLING_RATE);
    }

    function getAudioCodecId() {
      return $this->getCheck(self::AUDIO_CODEC_CHECK, self::AUDIO_CODEC_CHECK, self::AUDIO_CODEC_ID);
    }
  }
