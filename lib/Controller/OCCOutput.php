<?php

namespace OCA\OCCWeb\Controller;


use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\ConsoleSectionOutput;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method ConsoleSectionOutput section()
 */
class OccOutput extends BufferedOutput implements ConsoleOutputInterface
{

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

//  public function __call($name, $arguments) {
//    // TODO: Implement @method ConsoleSectionOutput section()
//  }
}
