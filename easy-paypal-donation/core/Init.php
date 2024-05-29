<?php
/**
 * Initialize all the core classes of the plugin
 */

namespace WPEasyDonation;

final class Init
{
	/**
	 * Store all the classes inside an array
	 * @return array (full list of classes)
	 */
	public static function getServices(): array
	{
		return [
			Base\Enqueue::class,
			Base\MediaButton::class,
			Base\NoticeController::class,
			Base\PpcpController::class,
			Base\Stripe::class,
			Base\Filter::class,
			Base\WidgetController::class,
			Base\Ipn::class,
			Pages\Dashboard::class,
		];
	}

	/**
	 * Loop through the classes, initialize them
	 * and call the register() method if it exists
	 */
	public static function registerServices()
	{
		foreach (self::getServices() as $class) {
			$service = self::instantiate($class);
			if (method_exists($service, 'register')) $service->register();
		}
	}

	/**
	 * Initialize the class
	 * @param $class. Class from services array
	 * return class instance. New instance of the class
	 */
	private static function instantiate($class)
	{
		return new $class();
	}
}