<?php

namespace OCA\OCCWeb\Controller;

use OCP\IRequest;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Controller;
use OCP\ILogger;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\OutputInterface;

class OccController extends Controller
{
  private $logger;
  private $userId;

  private $application;
  private $output;

  public $server;

  public function __construct(ILogger $logger, $AppName, IRequest $request, $UserId)
  {
    parent::__construct($AppName, $request);
    $this->logger = $logger;
    $this->userId = $UserId;

    $this->server = array(
      'argv' => ["occ"],
    );
    $this->application = new OCCApplication(
      \OC::$server->getConfig(),
      \OC::$server->getEventDispatcher(),
      \OC::$server->getLogger()/*,
      \OC::$server->query(\OC\MemoryInfo::class)*/
    );
    $this->application->setAutoExit(false);
//    $this->output = new OCCOutput();
    $this->output = new OccOutput(OutputInterface::VERBOSITY_NORMAL, true);
    $this->application->loadCommands(new StringInput(""), $this->output);
  }

  /**
   * CAUTION: the @Stuff turns off security checks; for this page no admin is
   *          required and no CSRF check. If you don't know what CSRF is, read
   *          it up in the docs or you might create a security hole. This is
   *          basically the only required method to add this exemption, don't
   *          add it to any other method if you don't exactly know what it does
   *
   * @NoCSRFRequired
   */
  public function index()
  {
    return new TemplateResponse('occweb', 'index');  // templates/index.php
  }

  private function run($input)
  {
    try {
      $this->application->run($input, $this->output);
      return $this->output->fetch();
    } catch (\Exception $ex) {
      exceptionHandler($ex);
    } catch (Error $ex) {
      exceptionHandler($ex);
    }
  }

  /**
   * @NoAdminRequired
   * @param string $command
   * @return DataResponse
   */
  public function cmd($command)
  {

    $this->logger->info($command);
    $input = new StringInput($command);
    // TODO : Interactive ?
    $response = $this->run($input);
//    $this->logger->info($response);
//    $converter = new AnsiToHtmlConverter();
//    return new DataResponse($converter->convert($response));
    return new DataResponse($response);
  }

  public function list() {
    $defs = $this->application->application->all();
    $cmds = array();
    foreach ($defs as $d) {
      array_push($cmds, $d->getName());
    }
    return new DataResponse($cmds);
  }
}

function exceptionHandler($exception)
{
  echo "An unhandled exception has been thrown:" . PHP_EOL;
  echo $exception;
  exit(1);
}
