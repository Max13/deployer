<?php

declare(strict_types=1);

/* (c) Anton Medvedev <anton@medv.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Deployer\Task;

use Deployer\Configuration;
use Deployer\Exception\Exception;
use Deployer\Host\Host;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Context
{
    private Host $host;

    /**
     * @var Context[]
     */
    private static array $contexts = [];

    public function __construct(Host $host)
    {
        $this->host = $host;
    }

    public static function push(Context $context): void
    {
        self::$contexts[] = $context;
    }

    public static function has(): bool
    {
        return !empty(self::$contexts);
    }

    public static function get(): Context
    {
        if (empty(self::$contexts)) {
            throw new Exception("Context was requested but was not available.");
        }
        return end(self::$contexts);
    }

    public static function pop(): ?Context
    {
        return array_pop(self::$contexts);
    }

    /**
     * Throws a Exception when not called within a task-context and therefore no Context is available.
     *
     * This method provides a useful error to the end-user to make him/her aware
     * to use a function in the required task-context.
     *
     * @throws Exception
     */
    public static function required(string $callerName): void
    {
        if (empty(self::$contexts)) {
            throw new Exception("'$callerName' can only be used within a task.");
        }
    }

    public function getConfig(): Configuration
    {
        return $this->host->config();
    }

    public function getHost(): Host
    {
        return $this->host;
    }
}
