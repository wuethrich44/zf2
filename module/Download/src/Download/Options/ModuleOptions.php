<?php

namespace Download\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{

    /**
     * @var string
     */
    protected $downloadFolderPath = 'data/uploads';

    public function setDownloadFolderPath($downloadFolderPath)
    {
        $this->downloadFolderPath = $downloadFolderPath;

        return $this;
    }

    public function getDownloadFolderPath()
    {
        return $this->downloadFolderPath;
    }
}
