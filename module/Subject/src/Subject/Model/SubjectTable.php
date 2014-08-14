<?php

namespace Subject\Model;

use Zend\Db\TableGateway\TableGateway;

class SubjectTable {

    protected $tableGateway;

    /**
     * Constructor
     *
     * @param TableGateway $tableGateway            
     */
    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    /**
     * Return all subjects
     *
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function fetchAll() {
        $select = $this->tableGateway->getSql()->select()->order('name');

        return $this->tableGateway->selectWith($select);
    }

    /**
     * Return a subject by ID
     *
     * @param int $subjectID            
     * @throws \Exception Subject not found
     * @return Subject
     */
    public function getSubject($subjectID) {
        $subjectID = (int) $subjectID;
        $rowset = $this->tableGateway->select(
                array(
                    'subjectID' => $subjectID
        ));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find subject with ID $subjectID");
        }
        return $row;
    }
    
    /**
     * Return a the subjectID by abbreviation
     * 
     * @param String $abbreviation 
     * @return int subjectID
     */
    public function getSubjectID($abbreviation) {
        $rowset = $this->tableGateway->select(
                array(
                    'abbreviation' => $abbreviation
        ));
        $row = $rowset->current();
        
        if(!$row) {
            return 0;
        }
        
        return $row->subjectID;
    }

    /**
     * Return all subjects which include files
     *
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function getUsedSubjects() {
        $select = $this->tableGateway->getSql()
                ->select()
                ->join('files', 'subjects.subjectID = files.subjectID')
                ->order('name')
                ->group('subjects.subjectID');

        return $this->tableGateway->selectWith($select);
    }

    /**
     * Return an array for the select form input element
     *
     * @return array
     */
    public function getSubjectsForSelect() {
        $subjects = $this->fetchAll();
        $array = array();
        foreach ($subjects as $subject) {
            $array[$subject->subjectID] = $subject->name . ' | ' .
                    $subject->abbreviation;
        }

        return $array;
    }

    /**
     * Save (insert or update) a subject object
     *
     * @param Subject $subject            
     * @throws \Exception Could not find subject
     */
    public function saveSubject(Subject $subject) {
        $data = array(
            'name' => $subject->name,
            'abbreviation' => $subject->abbreviation
        );

        $subjectID = (int) $subject->subjectID;
        if ($subjectID == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getSubject($subjectID)) {
                $this->tableGateway->update($data, array(
                    'subjectID' => $subjectID
                ));
            } else {
                throw new \Exception(
                "Could not find subject with ID $subjectID");
            }
        }
    }

    /**
     * Delete a subject with the specific ID
     *
     * @param int $subjectID            
     */
    public function deleteSubject($subjectID) {
        $this->tableGateway->delete(array(
            'subjectID' => (int) $subjectID
        ));
    }

}
