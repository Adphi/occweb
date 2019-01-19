<?php

namespace OCA\OCCWeb\Controller;

use OC\Console\Application;
use OCP\IRequest;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Controller;
use OCP\ILogger;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\OutputInterface;

class OccController extends Controller implements IRequest
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
    $this->application = new Application(
      \OC::$server->getConfig(),
      \OC::$server->getEventDispatcher(),
      $this,
      \OC::$server->getLogger(),
      \OC::$server->query(\OC\MemoryInfo::class)
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

  /**
   * Lets you access post and get parameters by the index
   * In case of json requests the encoded json body is accessed
   *
   * @param string $key the key which you want to access in the URL Parameter
   *                     placeholder, $_POST or $_GET array.
   *                     The priority how they're returned is the following:
   *                     1. URL parameters
   *                     2. POST parameters
   *                     3. GET parameters
   * @param mixed $default If the key is not found, this value will be returned
   * @return mixed the content of the array
   * @since 6.0.0
   */
  public function getParam(string $key, $default = null)
  {
    // TODO: Implement getParam() method.
  }

  /**
   * Returns all params that were received, be it from the request
   *
   * (as GET or POST) or through the URL by the route
   *
   * @return array the array with all parameters
   * @since 6.0.0
   */
  public function getParams(): array
  {
    // TODO: Implement getParams() method.
  }

  /**
   * Returns the method of the request
   *
   * @return string the method of the request (POST, GET, etc)
   * @since 6.0.0
   */
  public function getMethod(): string
  {
    // TODO: Implement getMethod() method.
  }

  /**
   * Shortcut for accessing an uploaded file through the $_FILES array
   *
   * @param string $key the key that will be taken from the $_FILES array
   * @return array the file in the $_FILES element
   * @since 6.0.0
   */
  public function getUploadedFile(string $key)
  {
    // TODO: Implement getUploadedFile() method.
  }

  /**
   * Shortcut for getting env variables
   *
   * @param string $key the key that will be taken from the $_ENV array
   * @return array the value in the $_ENV element
   * @since 6.0.0
   */
  public function getEnv(string $key)
  {
    // TODO: Implement getEnv() method.
  }

  /**
   * Shortcut for getting cookie variables
   *
   * @param string $key the key that will be taken from the $_COOKIE array
   * @return string|null the value in the $_COOKIE element
   * @since 6.0.0
   */
  public function getCookie(string $key)
  {
    // TODO: Implement getCookie() method.
  }

  /**
   * Checks if the CSRF check was correct
   *
   * @return bool true if CSRF check passed
   * @since 6.0.0
   */
  public function passesCSRFCheck(): bool
  {
    // TODO: Implement passesCSRFCheck() method.
  }

  /**
   * Checks if the strict cookie has been sent with the request if the request
   * is including any cookies.
   *
   * @return bool
   * @since 9.0.0
   */
  public function passesStrictCookieCheck(): bool
  {
    // TODO: Implement passesStrictCookieCheck() method.
  }

  /**
   * Checks if the lax cookie has been sent with the request if the request
   * is including any cookies.
   *
   * @return bool
   * @since 9.0.0
   */
  public function passesLaxCookieCheck(): bool
  {
    // TODO: Implement passesLaxCookieCheck() method.
  }

  /**
   * Returns an ID for the request, value is not guaranteed to be unique and is mostly meant for logging
   * If `mod_unique_id` is installed this value will be taken.
   *
   * @return string
   * @since 8.1.0
   */
  public function getId(): string
  {
    // TODO: Implement getId() method.
  }

  /**
   * Returns the remote address, if the connection came from a trusted proxy
   * and `forwarded_for_headers` has been configured then the IP address
   * specified in this header will be returned instead.
   * Do always use this instead of $_SERVER['REMOTE_ADDR']
   *
   * @return string IP address
   * @since 8.1.0
   */
  public function getRemoteAddress(): string
  {
    // TODO: Implement getRemoteAddress() method.
  }

  /**
   * Returns the server protocol. It respects reverse proxy servers and load
   * balancers.
   *
   * @return string Server protocol (http or https)
   * @since 8.1.0
   */
  public function getServerProtocol(): string
  {
    // TODO: Implement getServerProtocol() method.
  }

  /**
   * Returns the used HTTP protocol.
   *
   * @return string HTTP protocol. HTTP/2, HTTP/1.1 or HTTP/1.0.
   * @since 8.2.0
   */
  public function getHttpProtocol(): string
  {
    // TODO: Implement getHttpProtocol() method.
  }

  /**
   * Returns the request uri, even if the website uses one or more
   * reverse proxies
   *
   * @return string
   * @since 8.1.0
   */
  public function getRequestUri(): string
  {
    // TODO: Implement getRequestUri() method.
  }

  /**
   * Get raw PathInfo from request (not urldecoded)
   *
   * @throws \Exception
   * @return string Path info
   * @since 8.1.0
   */
  public function getRawPathInfo(): string
  {
    // TODO: Implement getRawPathInfo() method.
  }

  /**
   * Get PathInfo from request
   *
   * @throws \Exception
   * @return string|false Path info or false when not found
   * @since 8.1.0
   */
  public function getPathInfo()
  {
    // TODO: Implement getPathInfo() method.
  }

  /**
   * Returns the script name, even if the website uses one or more
   * reverse proxies
   *
   * @return string the script name
   * @since 8.1.0
   */
  public function getScriptName(): string
  {
    // TODO: Implement getScriptName() method.
  }

  /**
   * Checks whether the user agent matches a given regex
   *
   * @param array $agent array of agent names
   * @return bool true if at least one of the given agent matches, false otherwise
   * @since 8.1.0
   */
  public function isUserAgent(array $agent): bool
  {
    // TODO: Implement isUserAgent() method.
  }

  /**
   * Returns the unverified server host from the headers without checking
   * whether it is a trusted domain
   *
   * @return string Server host
   * @since 8.1.0
   */
  public function getInsecureServerHost(): string
  {
    // TODO: Implement getInsecureServerHost() method.
  }

  /**
   * Returns the server host from the headers, or the first configured
   * trusted domain if the host isn't in the trusted list
   *
   * @return string Server host
   * @since 8.1.0
   */
  public function getServerHost(): string
  {
    // TODO: Implement getServerHost() method.
  }

  /**
   * @param string $name
   *
   * @return string
   * @since 6.0.0
   */
  public function getHeader(string $name): string
  {
    // TODO: Implement getHeader() method.
  }
}

function exceptionHandler($exception)
{
  echo "An unhandled exception has been thrown:" . PHP_EOL;
  echo $exception;
  exit(1);
}
