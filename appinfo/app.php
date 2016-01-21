<?php
/**
 * ownCloud - activity_ext
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author eric <test@test.com>
 * @copyright eric 2016
 */

namespace OCA\Activity_Ext\AppInfo;

$app = new Application();
$app->getContainer()->query('FilesHook')->register();

\OCA\Activity_Ext\HookStatic::register();

\OC::$server->getActivityManager()->registerExtension(function() {
    return new \OCA\Activity_Ext\Activity(
        \OC::$server->query('L10NFactory'),
        \OC::$server->getURLGenerator(),
        \OC::$server->getActivityManager()
    );
});
