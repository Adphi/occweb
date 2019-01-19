<?php
/**
 * Created by IntelliJ IDEA.
 * User: philippe-adrien
 * Date: 2019-01-18
 * Time: 19:08
 */

namespace OCA\TestNextcloudApp\Controller;


use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OCCOutput extends BufferedOutput implements ConsoleOutputInterface
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
}
