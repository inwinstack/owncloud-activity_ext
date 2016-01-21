<?php

namespace OCA\Activity_Ext;

use OCP\Util;

class HookStatic {
    public static function register() {
		Util::connectHook('OC_Filesystem', 'post_rename', 'OCA\Activity_Ext\HookStatic', 'fileRename');
    }

    static protected function getHooks() {
		$app = new \OCA\Activity_Ext\AppInfo\Application();
		return $app->getContainer()->query('Hooks');
	}

    public static function fileRename($params) {
		self::getHooks()->fileRenameOrMove($params);
    }
}

?>
