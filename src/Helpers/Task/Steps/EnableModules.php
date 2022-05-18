<?php

namespace AcquiaCMS\Cli\Helpers\Task\Steps;

use AcquiaCMS\Cli\Enum\StatusCodes;
use AcquiaCMS\Cli\Helpers\Parsers\JsonParser;
use AcquiaCMS\Cli\Helpers\Process\Commands\Drush;

/**
 * Run the drush command to enable Drupal modules.
 */
class EnableModules {

  /**
   * A drush command object.
   *
   * @var \AcquiaCMS\Cli\Helpers\Process\Commands\Drush
   */
  protected $drushCommand;

  /**
   * Constructs an object.
   *
   * @param \AcquiaCMS\Cli\Helpers\Process\Commands\Drush $drush
   *   Holds the drush command class object.
   */
  public function __construct(Drush $drush) {
    $this->drushCommand = $drush;
  }

  /**
   * Run the drush commands to enable Drupal modules.
   *
   * @param array $args
   *   An array of params argument to pass.
   */
  public function execute(array $args = []) :int {
    $packages = JsonParser::installPackages($args['modules']['install']);
    $command = array_merge(["en", "--yes"], $packages);
    $args['keys']['STARTER_KIT_PROGRESS'] = 1;
    $this->drushCommand->prepare($command)->run($args['keys']);
    return StatusCodes::OK;
  }

}
