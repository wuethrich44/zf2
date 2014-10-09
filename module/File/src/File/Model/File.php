<?php

namespace File\Model;

class File
{

    public $id;
    public $name;
    public $url;
    public $downloadCount;

    /**
     * Used by TableGateway to fill the object
     * 
     * @param array $data
     */
    public function exchangeArray($data)
    {
        $this->id = (!empty($data['fileID'])) ? $data['fileID'] : null;
        $this->name = (!empty($data['fileName'])) ? $data['fileName'] : null;
        $this->url = (!empty($data['url'])) ? $data['url'] : null;
        $this->downloadCount = (!empty($data['downloadCount'])) ? $data['downloadCount'] : 0;
    }
}
