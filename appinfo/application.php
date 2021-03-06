<?php
/**
 * ownCloud - files_mv
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author eotryx <mhfiedler@gmx.de>
 * @copyright eotryx 2015
 */


namespace OCA\Activity_Ext\Appinfo;

use OC\Files\View;
use OC\AppFramework\Utility\SimpleContainer;
use OCA\Files\Controller\ApiController;
use OCP\AppFramework\App;
use \OCA\Files\Service\TagService;
use \OCP\IContainer;
use \OCA\Activity_Ext\Hook;
use \OCA\Activity_Ext\Hooks\FilesHook;
class Application extends App {
	public function __construct(array $urlParams=array()) {
		parent::__construct('activity_ext', $urlParams);
		$container = $this->getContainer();
        
        $container->registerService('ActivityApplication', function($c){
            return new \OCA\Activity\AppInfo\Application();
        });

        $container->registerService('Hooks', function(IContainer $c) {
			/** @var \OC\Server $server */
			$server = $c->query('ServerContainer');

			return new Hook(
				$server->getActivityManager(),
				$c->query('ActivityApplication')->getContainer()->query('ActivityData'),
				$c->query('ActivityApplication')->getContainer()->query('UserSettings'),
				$server->getGroupManager(),
				new View(''),
				$server->getDatabaseConnection(),
				$c->query('CurrentUID')
			);
		});
        
        $container->registerService('FilesHook', function($c) {
            return new FilesHook(
                $c->query('ServerContainer')->getRootFolder(),
                $c->query('Hooks')
            );

        });

        $container->registerService('CurrentUID', function(IContainer $c) {
			/** @var \OC\Server $server */
			$server = $c->query('ServerContainer');

			$user = $server->getUserSession()->getUser();
			return ($user) ? $user->getUID() : '';
		});

	}
}
