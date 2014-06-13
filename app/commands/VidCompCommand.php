<?php

  use Illuminate\Console\Command;
  use Symfony\Component\Console\Input\InputOption;
  use Symfony\Component\Console\Input\InputArgument;

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

      $this->showResults($output);
    }

    /**
     * Show results
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
      return array( //array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
      );
    }

  }
