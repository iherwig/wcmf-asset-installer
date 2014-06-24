<?php
namespace wcmf\Composer;

use Composer\Composer;
use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;
use Composer\IO\IOInterface;

class AssetInstaller extends LibraryInstaller {

  const PACKAGE_TYPE = 'wcmf-asset';
  const DEFAULT_INSTALL_DIR = 'app/public/vendor/';
  
  private $defaultInstallDir;

  public function __construct(IOInterface $io, Composer $composer, $type=self::PACKAGE_TYPE) {
    parent::__construct($io, $composer, $type);

    // check for default installation path
    $config = $composer->getConfig();
    $this->defaultInstallDir = $config->has('wcmf-asset-install-dir') ? 
      $config->get('wcmf-asset-install-dir') : self::DEFAULT_INSTALL_DIR;
  }
    
  public function getInstallPath(PackageInterface $package) {
    $basePath = $this->defaultInstallDir;
  
    // check for package specific installation path
    $extra = $package->getExtra();
    if (isset($extra['install-dir'])) {
      $basePath = $extra['install-dir'];
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