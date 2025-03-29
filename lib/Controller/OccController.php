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
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\OutputInterface;
use Psr\Log\LoggerInterface;

class OccController extends Controller
{
  private $logger;
  private $userId;

  private $application;
  private $symphonyApplication;
  private $output;

  public function __construct($AppName, IRequest $request, $userId)
  {
    parent::__construct($AppName, $request);
    $this->logger = OC::$server->get(LoggerInterface::class);
    $this->userId = $userId;

    $this->application = new Application(
      OC::$server->getConfig(),
      OC::$server->get(\OCP\EventDispatcher\IEventDispatcher::class),
      new FakeRequest(),
      $this->logger,
      OC::$server->query(MemoryInfo::class),
      OC::$server->get(\OCP\App\IAppManager::class) // Obtain the IAppManager
    );
    $this->application->setAutoExit(false);
    $this->output = new OccOutput(OutputInterface::VERBOSITY_NORMAL, true);
    $this->application->loadCommands(new StringInput(""), $this->output);    
    $reflectionProperty = new \ReflectionProperty(Application::class, 'application');
    $reflectionProperty->setAccessible(true);
    $this->symphonyApplication = $reflectionProperty->getValue($this->application);
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
      $this->logger->error($ex->getMessage(), ['exception' => $ex]);
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
    $defs = $this->symphonyApplication->all();
    $cmds = array();
    foreach ($defs as $d) {
      array_push($cmds, $d->getName());
    }
    return new DataResponse($cmds);
  }
}

