<?php
/**
 * @license GPL-2.0-only
 *
 * Modified by kadencewp on 11-January-2024 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */ declare(strict_types=1);

namespace KadenceWP\KadenceBlocks\StellarWP\ProphecyMonorepo\Log;

use KadenceWP\KadenceBlocks\lucatume\DI52\Container;
use KadenceWP\KadenceBlocks\Monolog\Handler\AbstractHandler;
use KadenceWP\KadenceBlocks\Monolog\Handler\ErrorLogHandler;
use KadenceWP\KadenceBlocks\Monolog\Handler\StreamHandler;
use KadenceWP\KadenceBlocks\Monolog\Logger;
use KadenceWP\KadenceBlocks\Psr\Log\LoggerInterface;
use RuntimeException;
use KadenceWP\KadenceBlocks\StellarWP\ProphecyMonorepo\Container\Contracts\Provider;
use KadenceWP\KadenceBlocks\StellarWP\ProphecyMonorepo\Log\Formatters\ColoredLineFormatter;
use KadenceWP\KadenceBlocks\StellarWP\ProphecyMonorepo\Log\Handlers\NullHandler;

final class LogProvider extends Provider
{
	public const CHANNELS = [
		'console'  => [
			'class'     => StreamHandler::class,
			'formatter' => ColoredLineFormatter::class,
		],
		'errorlog' => [
			'class' => ErrorLogHandler::class,
		],
		'null'     => [
			'class' => NullHandler::class,
		],
	];

	/**
	 * {@inheritDoc}
	 */
	public function register(): void {
		$this->container->when(ColoredLineFormatter::class)
						->needs('$dateFormat')
						->give('Y-m-d H:i:s.v e');

		$this->container->when(AbstractHandler::class)
						->needs('$level')
						->give(LogLevel::fromName($this->config->get('log.level')));

		$channel = $this->config->get('log.channel');

		$this->container->singleton(
			StreamHandler::class,
			function () use ($channel) {
				return new StreamHandler($this->config->get("log.channels.$channel.with.stream", ''));
			}
		);

		$this->container->bind(
			LoggerInterface::class,
			static function (Container $c) use ($channel): LoggerInterface {
				$handler = self::CHANNELS[$channel] ?? false;

				if (! $handler) {
					throw new RuntimeException(
						sprintf(
							'Invalid log channel. Valid options are: %s',
							implode(',', array_keys(self::CHANNELS))
						)
					);
				}

				/** @var \KadenceWP\KadenceBlocks\Monolog\Handler\AbstractProcessingHandler $handlerInstance */
				$handlerInstance = $c->get($handler['class']);

				$logger = new Logger($channel);

				if (isset($handler['formatter'])) {
					$handlerInstance->setFormatter($c->get($handler['formatter']));
				}

				$logger->pushHandler($handlerInstance);

				return $logger;
			}
		);
	}
}
