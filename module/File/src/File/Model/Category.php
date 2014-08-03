<?php

namespace File\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Category implements InputFilterAwareInterface {

    public $categoryID;
    public $name;
    protected $inputFilter;
    protected $dbAdapter;

    /**
     * Used by TableGateway to fill the instance
     *
     * @param array $data            
     */
    public function exchangeArray($data) {
        $this->categoryID = (!empty($data['categoryID'])) ? $data['categoryID'] : null;
        $this->name = (!empty($data['name'])) ? $data['name'] : null;
    }

    /**
     * Return this object as an array
     *
     * @return array
     */
    public function getArrayCopy() {
        return get_object_vars($this);
    }

    /**
     * Set DbAdapter for NoRecordExists
     *
     * @param Adapter $dbAdapter            
     */
    public function setDbAdapter($dbAdapter) {
        $this->dbAdapter = $dbAdapter;
    }

    /**
     * Get DbAdapter
     *
     * @return Adapter
     */
    public function getDbAdapter() {
        return $this->dbAdapter;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Zend\InputFilter\InputFilterAwareInterface::setInputFilter()
     */
    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \BadMethodCallException('Method not implemented');
    }

    /**
     * Define the InputFilters
     *
     * (non-PHPdoc)
     *
     * @see \Zend\InputFilter\InputFilterAwareInterface::getInputFilter()
     */
    public function getInputFilter() {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add(
                    array(
                        'name' => 'categoryID',
                        'required' => true,
                        'filters' => array(
                            array(
                                'name' => 'Int'
                            )
                        )
            ));

            $inputFilter->add(
                    array(
                        'name' => 'name',
                        'required' => true,
                        'filters' => array(
                            array(
                                'name' => 'StripTags',
                            ),
                            array(
                                'name' => 'StringTrim',
                            ),
                        ),
                        'validators' => array(
                            array(
                                'name' => 'StringLength',
                                'options' => array(
                                    'encoding' => 'UTF-8',
                                    'min' => 1,
                                    'max' => 100,
                                )
                            ),
                            array(
                                'name' => 'Alnum',
                            ),
                            array(
                                'name' => '\Zend\Validator\Db\NoRecordExists',
                                'options' => array(
                                    'table' => 'categories',
                                    'field' => 'name',
                                    'adapter' => $this->dbAdapter,
                                )
                            )
                        )
            ));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}

?>