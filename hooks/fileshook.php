<?php

namespace OCA\Activity_Ext\Hooks;

use OCP\Util;
use OCA\Activity_Ext\Hook;
class FilesHook {
    
    private $rootFolder;
    private $hook;

    public function __construct($rootFolder,Hook $hook) {
        $this->rootFolder = $rootFolder;
        $this->hook = $hook;
    }
    
    public function register() {

        $copy  = function($source, $target) {
            
            $this->hook->fileCopy($source->getInternalPath(), $target->getInternalPath());
        };
        
        $this->rootFolder->listen('\OC\Files','postCopy',$copy);
    }
}

?>
