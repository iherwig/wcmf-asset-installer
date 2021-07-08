<?php
namespace wcmf\Composer;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

class AssetInstallerPlugin implements PluginInterface {
  private AssetInstaller $installer;

  public function activate(Composer $composer, IOInterface $io) {
    $this->installer = new AssetInstaller($io, $composer);
    $composer->getInstallationManager()->addInstaller($this->installer);
  }

  public function deactivate(Composer $composer, IOInterface $io) {
    $composer->getInstallationManager()->removeInstaller($this->installer);
  }
}
?>