<?php

namespace Category\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Db\Adapter\Adapter;

class Category implements InputFilterAwareInterface {

    public $categoryID;
    public $name;
    public $fileCount;
    protected $inputFilter;
    protected $dbAdapter;

    /**
     * Constructor
     * 
     * @param \Zend\Db\Adapter\Adapter $dbAdapter
     */
    public function __construct(Adapter $dbAdapter) {
        $this->dbAdapter = $dbAdapter;
    }

    /**
     * Used by TableGateway to fill the instance
     *
     * @param array $data            
     */
    public function exchangeArray($data) {
        $this->categoryID = (!empty($data['categoryID'])) ? $data['categoryID'] : null;
        $this->name = (!empty($data['name'])) ? $data['name'] : null;
        $this->fileCount = (!empty($data['fileCount'])) ? $data['fileCount'] : null;
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
                                    'exclude' => array(
                                        'field' => 'categoryID',
                                        'value' => $this->categoryID,
                                    ),
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
