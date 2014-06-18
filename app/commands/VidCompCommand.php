<?php

  use Illuminate\Console\Command;
  use Symfony\Component\Console\Input\InputOption;
  use Symfony\Component\Console\Input\InputArgument;

  /**
   * Class VidCompCommand
   *
   * Adds a laravel artisan command to display information about the passed in files
   */
  class VidCompCommand extends Command
  {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'vidcomp:file';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Compare video data.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
      parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire() {
      $file = $this->argument("file");

      $comparisonRunner = new ComparisonRunner();
      $output = $comparisonRunner->getFileOutput($file);

      if ($this->option('xml')) {
        $this->showResultsXml($output);
      } else {
        $this->showResults($output);
      }
    }

    /**
     * Show results as xml
     *
     * @param array $results
     */
    protected function showResultsXML($results) {
      $doc = new DomDocument("1.0");
      $doc->formatOutput = true;

      $root = $doc->createElement('vidcomp');
      $root = $doc->appendChild($root);

      foreach ($results as $header => $tests) {
        $section = $doc->createElement('section');
        $root->appendChild($section);
        $sectionTitle = $doc->createElement('section-title');
        $section->appendChild($sectionTitle);
        $sectionText = $doc->createTextNode($header);
        $sectionTitle->appendChild($sectionText);

        foreach ($tests as $test => $toolResults) {
          $testType = $doc->createElement('test');
          $section->appendChild($testType);
          $testTitle = $doc->createElement('test-title');
          $testType->appendChild($testTitle);
          $typeText = $doc->createTextNode($test);
          $testTitle->appendChild($typeText);

          foreach ($toolResults as $tool => $toolResult) {
            $toolType = $doc->createElement('tool');
            $testType->appendChild($toolType);
            $toolName = $doc->createElement('name');
            $toolType->appendChild($toolName);
            $toolText = $doc->createTextNode($tool);
            $toolName->appendChild($toolText);

            $toolResultType = $doc->createElement('result');
            $toolType->appendChild($toolResultType);
            $toolResultText = $doc->createTextNode($toolResult);
            $toolResultType->appendChild($toolResultText);
          }
        }
      }

      echo $doc->saveXML();
    }

    /**
     * Show results to console
     *
     * @param array $results
     */
    protected function showResults($results) {
      foreach ($results as $header => $tests) {
        $this->info("" . $header);
        foreach ($tests as $test => $toolResults) {
          $this->info("\t" . $test);
          foreach ($toolResults as $tool => $toolResult) {
            $this->info("\t\t" . str_pad($tool, 10) . " : " . $toolResult);
          }
        }
      }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments() {
      return array(
          array('file', InputArgument::REQUIRED, 'File to run comparison.'),
      );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions() {
      return array(array('xml', null, InputOption::VALUE_NONE, 'Output results as xml.', null),
      );
    }

  }
