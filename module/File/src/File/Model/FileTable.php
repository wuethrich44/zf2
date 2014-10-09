<?php

namespace File\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;

class FileTable
{

    protected $tableGateway;

    /**
     * Constructor
     *
     * @param TableGateway $tableGateway            
     */
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * Return all files
     *
     * @return ResultSet
     */
    public function fetchAll()
    {
        $select = $this->tableGateway->getSql()->select()->order('name');

        return $this->tableGateway->selectWith($select);
    }

    /**
     * Return a file by ID
     * 
     * @param int $subjectID
     * @param int $categoryID   
     * @param int $fileID         
     * @throws \Exception File not found
     * @return File
     */
    public function getFile($subjectID, $categoryID, $fileID)
    {
        $subjectID = (int) $subjectID;
        $categoryID = (int) $categoryID;
        $fileID = (int) $fileID;
        $rowset = $this->tableGateway->select(
            array(
                'subjectID' => $subjectID,
                'categoryID' => $categoryID,
                'fileID' => $fileID
            )
        );
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find file with ID $fileID");
        }
        return $row;
    }

    /**
     * Get all files in the appropriate subject and categorie
     *
     * @param int $subjectID            
     * @param int $categoryID            
     * @return ResultSet
     */
    public function getFiles($subjectID, $categoryID)
    {
        $select = $this->tableGateway->getSql()
                ->select()
                ->where(array('subjectID' => $subjectID,'categoryID' => $categoryID))
                ->order('filename');

        return $this->tableGateway->selectWith($select);
    }

    /**
     * Save the given file
     *
     * @param File $file            
     * @param int $subjectID            
     * @param int $categoryID            
     * @throws \Exception File not found
     */
    public function saveFile(File $file, $subjectID, $categoryID)
    {
        $subjectID = (int) $subjectID;
        $categoryID = (int) $categoryID;

        $data = array(
            'fileID' => $file->id,
            'subjectID' => $subjectID,
            'categoryID' => $categoryID,
            'fileName' => $file->name,
            'url' => $file->url
        );

        $fileID = (int) $file->id;

        if ($fileID == 0) {
            // If no ID given insert a new file
            $this->tableGateway->insert($data);
        } else {
            if ($this->getFile($subjectID, $categoryID, $fileID)) {
                $this->tableGateway->update($data, array(
                    'subjectID' => $subjectID,
                    'categoryID' => $categoryID,
                    'fileID' => $fileID
                ));
            } else {
                throw new \Exception("Could not find file with ID $fileID");
            }
        }
    }

    /**
     * Delete the given file
     *
     * @param int $fileID            
     * @throws \BadMethodCallException
     */
    public function deleteFile($fileID)
    {
        $this->tableGateway->delete(array(
            'fileID' => (int) $fileID
        ));
    }

    /**
     * Increment the download count of the given file
     *
     * @param File $file            
     * @throws \Exception Could not icrement
     */
    public function incrementDownloadCount(File $file)
    {
        if ($file instanceof File) {
            $data = array(
                'downloadCount' => $file->downloadCount + 1
            );
            $this->tableGateway->update($data, array(
                'fileID' => $file->id
            ));
        } else {
            throw new \Exception("Could not increment the download counter");
        }
    }
}
