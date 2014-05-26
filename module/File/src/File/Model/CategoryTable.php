<?php

namespace File\Model;

use Zend\Db\TableGateway\TableGateway;

class CategoryTable {

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
     * Return all categories
     *
     * @return ResultSet with Categories
     */
    public function fetchAll() {
        $select = $this->tableGateway->getSql()->select()->order('name');

        return $this->tableGateway->selectWith($select);
    }

    /**
     * Return a categorie by ID
     *
     * @param int $categoryID            
     * @throws \Exception Categorie not found
     * @return Category
     */
    public function getCategory($categoryID) {
        $categoryID = (int) $categoryID;
        $rowset = $this->tableGateway->select(
                array(
                    'categoryID' => $categoryID
        ));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find category with ID $categoryID");
        }
        return $row;
    }

    /**
     * Return all modules which include files
     *
     * @param unknown $moduleID            
     * @return ResultSet with Categories
     */
    public function getUsedCategories($moduleID) {
        $moduleID = (int) $moduleID;

        $select = $this->tableGateway->getSql()
                ->select()
                ->join('files', 'categories.categoryID = files.categoryID')
                ->where(
                        array(
                            'files.subjectID' => $moduleID
                ))
                ->order('name')
                ->group('categories.categoryID');

        return $this->tableGateway->selectWith($select);
    }

    /**
     * Return an array for the select form input element
     *
     * @return array
     */
    public function getCategoriesForSelect() {
        $categories = $this->fetchAll();
        $array = array();
        foreach ($categories as $category) {
            $array[$category->categoryID] = $category->name;
        }

        return $array;
    }

    /**
     * Save (insert or update) a category object
     * 
     * @param Category $category
     * @throws \Exception Could not find category
     */
    public function saveCategory(Category $category) {
        $data = array(
            'name' => $category->name
        );

        $categoryID = (int) $category->categoryID;
        if ($categoryID == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getCategory($categoryID)) {
                $this->tableGateway->update($data, array(
                    'categoryID' => $categoryID
                ));
            } else {
                throw new \Exception(
                "Could not find category with ID $categoryID");
            }
        }
    }

    /**
     * Delete a category with the specific ID
     * 
     * @param int $categoryID
     */
    public function deleteCategory($categoryID) {
        $this->tableGateway->delete(array('categoryID' => (int) $categoryID));
    }

}
