<?php

namespace OCA\OCCWeb\Controller;

use Exception;
use OC;
use OC\Console\Application;
use OC\MemoryInfo;
use OCP\IRequest;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Controller;
use OCP\ILogger;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\OutputInterface;
use Psr\Log\LoggerInterface;

class OccController extends Controller
{
  private $logger;
  private $userId;

  private $application;
  private $output;

  public function __construct(ILogger $logger, $AppName, IRequest $request, $userId)
  {
    parent::__construct($AppName, $request);
    $this->logger = $logger;
    $this->userId = $userId;

    $this->application = new Application(
      OC::$server->getConfig(),
      OC::$server->getEventDispatcher(),
      new FakeRequest(),
      OC::$server->get(LoggerInterface::class),
      OC::$server->query(MemoryInfo::class)
    );
    $this->application->setAutoExit(false);
    $this->output = new OccOutput(OutputInterface::VERBOSITY_NORMAL, true);
    $this->application->loadCommands(new StringInput(""), $this->output);
  }

  /**
   * @NoCSRFRequired
   */
  public function index()
  {
    return new TemplateResponse('occweb', 'index');
  }

  /**
   * @param $input
   * @return string
   */
  private function run($input)
  {
    try {
      $this->application->run($input, $this->output);
      return $this->output->fetch();
    } catch (Exception $ex) {
      $this->logger->logException($ex);
      return "error: " . $ex->getMessage();
    }
  }

  /**
   * @param string $command
   * @return DataResponse
   */
  public function cmd($command)
  {
    $this->logger->debug($command);
    $input = new StringInput($command);
    $response = $this->run($input);
    $this->logger->debug($response);
    return new DataResponse($response);
  }

  public function list() {
    // $defs = $this->application->application->all();
    $cmds = array();
    // foreach ($defs as $d) {
    //   array_push($cmds, $d->getName());
    // }
    return new DataResponse($cmds);
  }
}

