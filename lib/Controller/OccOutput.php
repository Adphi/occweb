<?php

namespace OCA\OCCWeb\Controller;


use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\ConsoleSectionOutput;
use Symfony\Component\Console\Output\OutputInterface;


class OccOutput extends BufferedOutput implements ConsoleOutputInterface
{
  private $consoleSectionOutputs = [];

  private $stream;
  /**
   * Gets the OutputInterface for errors.
   *
   * @return OutputInterface
   */
  public function getErrorOutput()
  {
    // TODO: Implement getErrorOutput() method.
    return $this;
  }

  public function setErrorOutput(OutputInterface $error)
  {

  }

  /**
   * Creates a new output section.
   */
  public function section(): ConsoleSectionOutput {
    if ($this->stream === null) {
      $this->stream = fopen('php://temp','w');
    }
    return new ConsoleSectionOutput($this->stream, $this->consoleSectionOutputs, $this->getVerbosity(), $this->isDecorated(), $this->getFormatter());
  }

}
