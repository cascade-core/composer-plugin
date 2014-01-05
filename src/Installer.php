<?php
namespace Cascade\ComposerPlugin;

use Composer\Installer\LibraryInstaller;
use Composer\Package\PackageInterface;

class Installer extends LibraryInstaller
{

	/**
	 * {@inheritDoc}
	 */
	public function getInstallPath(PackageInterface $package)
	{
		$type = $package->getType();
		$extra = $package->getExtra();
		$plugin = @ $extra['plugin'];

		if ($type == 'cascade-core') {
			return 'core';
		}

		if ($plugin == '') {
			throw new \Exception('Plugin name not specified! Set extra.plugin option in composer.json to valid plugin name.');
		}

		if (!preg_match('/^[a-z0-9]([a-z0-9_]*[a-z0-9])?$/', $plugin)) {
			throw new \Exception('Plugin name "'.$plugin.'" is invalid! Set extra.plugin option in composer.json to valid plugin name -- a-z, 0-9 and underscore only.');
		}

		return 'plugin/'.$plugin;
	}

	/**
	 * {@inheritDoc}
	 */
	public function supports($packageType)
	{
		return $packageType == 'cascade-plugin' || $packageType == 'cascade-core';
	}

}

