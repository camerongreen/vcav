<?php

  /**
   * Class ToolBase
   *
   * Base class for the media probing tools
   */
  abstract class ToolBase
  {
    const IGNORE_STDERR = ' 2> /dev/null';

    /**
     * The filename we are working on
     *
     * @var string
     */
    protected $filename;

    /**
     * The simplexml object we are working on
     *
     * @var Object
     */
    protected $xml;

    /**
     * The command to be run
     *
     * @var string
     */
    protected $command;

    public function __construct($filename) {
      $this->filename = $filename;
    }

    /**
     * Runs the command and returns output, or null in event of error
     *
     * @return string
     */
    public function getRawOutput() {
      $command = $this->command . ' ' . escapeshellarg($this->filename) . ' ' . self::IGNORE_STDERR;
      $result = shell_exec($command);
      return $result;
    }
  }
