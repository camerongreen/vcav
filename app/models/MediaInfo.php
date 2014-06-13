<?php

  /**
   * Class MediaInfo
   *
   * Runs the MediInfo tool and returns information about the passed in filename
   */
class MediaInfo extends ToolBase {
  // todo: put into config
  protected $command = '/usr/local/bin/mediainfo -f --Language=raw --Output=XML';

  /**
   * Xpath constants to access elements
   */
  const FILE_FORMAT = '//track[@type="General"]/Format';
  const FILE_FORMAT_PROFILE = '//track[@type="General"]/Format_Profile';
  const FILE_SIZE = '//track[@type="General"]/FileSize';
  const DURATION = '//track[@type="General"]/Duration';
  const OVERALL_BITRATE = '//track[@type="General"]/OverallBitRate_String';
  const CODEC = '//track[@type="Video"]/Format';
  const CODEC_ID = '//track[@type="Video"]/CodecID';
  const CODEC_PROFILE = '//Format_Profile';
  const DISPLAY_ASPECT_RATIO = '//track[@type="Video"]/DisplayAspectRatio';
  const FRAME_RATE = '//track[@type="Video"]/FrameRate';
  const AUDIO_CODEC = '//track[@type="Audio"]/Format';
  const AUDIO_CODEC_ID = '//track[@type="Audio"]/CodecID';
  const AUDIO_SAMPLING_RATE = '//track[@type="Audio"]/SamplingRate';

  public function __construct($filename) {
    parent::__construct($filename);
  }

  public function parse() {
    $stringXml = $this->getRawOutput();
    $this->xml = new SimpleXmlElement($stringXml);
  }

  function getSimple($xpath) {
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

  function getCodec() {
    return $this->getSimple(self::CODEC);
  }

  function getCodecId() {
    return $this->getSimple(self::CODEC_ID);
  }

  function getCodecProfile() {
    return $this->getSimple(self::CODEC_PROFILE);
  }

  function getDisplayAspectRatio() {
    return $this->getSimple(self::DISPLAY_ASPECT_RATIO);
  }

  function getFrameRate() {
    return $this->getSimple(self::FRAME_RATE);
  }

  function getAudioCodec() {
    return $this->getSimple(self::AUDIO_CODEC);
  }

  function getAudioCodecId() {
    return $this->getSimple(self::AUDIO_CODEC_ID);
  }

  function getAudioSamplingRate() {
    return $this->getSimple(self::AUDIO_SAMPLING_RATE);
  }
}
