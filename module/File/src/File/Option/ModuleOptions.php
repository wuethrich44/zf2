<?php

namespace File\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions {

    /**
     * @var string
     */
    protected $uploadFolderPath = 'data/uploads';
    
    /**
     * @var int 
     */
    protected $maxFileSizeInByte = 10000000; // 10 MByte

    public function setUploadFolderPath($uploadFolderPath) {
        $this->uploadFolderPath = $uploadFolderPath;

        return $this;
    }

    public function getUploadFolderPath() {
        if (!$this->uploadFolderPath === null && !is_dir($this->uploadFolderPath)) {
            mkdir($this->uploadFolderPath);
        }

        return $this->uploadFolderPath;
    }

    public function setMaxFileSizeInByte($maxFileSizeInByte) {
        $this->maxFileSizeInByte = $maxFileSizeInByte;

        return $this;
    }

    public function getMaxFileSizeInByte() {
        return $this->maxFileSizeInByte;
    }

}
