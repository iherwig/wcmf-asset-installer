<?php
namespace wcmf\Composer;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;

class AssetInstaller extends LibraryInstaller {

  const PACKAGE_TYPE = 'wcmf-asset';
  const DEFAULT_INSTALL_DIR = 'app/public/vendor/';

  public function getInstallPath(PackageInterface $package) {
    $basePath = self::DEFAULT_INSTALL_DIR;
  
    // check package specific installation path
    $extra = $package->getExtra();
    if (isset($extra['install-dir'])) {
      $basePath = $extra['install-dir'];
    }
    // check root installation path
    else {
      $config = $composer->getConfig();
      if ($config->has('wcmf-asset-install-dir')) {
        basePath = $config->get('wcmf-asset-install-dir');
      }
    }
    // add trailing slash if missing
    if (!preg_match('/\/$/', $basePath)) {
      $basePath .= '/';
    }
    return $basePath.$package->getPrettyName();
  }

  public function supports($packageType) {
    return (bool)(self::PACKAGE_TYPE === $packageType);
  }
}
?>