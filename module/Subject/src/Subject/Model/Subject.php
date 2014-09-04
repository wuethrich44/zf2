<?php

namespace Subject\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Db\Adapter\Adapter;

class Subject implements InputFilterAwareInterface {

    public $subjectID;
    public $name;
    public $abbreviation;
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
     * Used by TableGateway to fill the object
     *
     * @param array $data            
     */
    public function exchangeArray($data) {
        $this->subjectID = (!empty($data['subjectID'])) ? $data['subjectID'] : null;
        $this->name = (!empty($data['name'])) ? $data['name'] : null;
        $this->abbreviation = (!empty($data['abbreviation'])) ? $data['abbreviation'] : null;
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
                        'name' => 'subjectID',
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
                                'name' => 'StripTags'
                            ),
                            array(
                                'name' => 'StringTrim'
                            )
                        ),
                        'validators' => array(
                            array(
                                'name' => 'StringLength',
                                'options' => array(
                                    'encoding' => 'UTF-8',
                                    'min' => 1,
                                    'max' => 100
                                )
                            ),
                            array(
                                'name' => '\Zend\Validator\Db\NoRecordExists',
                                'options' => array(
                                    'table' => 'subjects',
                                    'field' => 'name',
                                    'exclude' => array(
                                        'field' => 'subjectID',
                                        'value' => $this->subjectID,
                                    ),
                                    'adapter' => $this->dbAdapter,
                                )
                            )
                        )
            ));

            $inputFilter->add(
                    array(
                        'name' => 'abbreviation',
                        'required' => true,
                        'filters' => array(
                            array(
                                'name' => 'StripTags',
                            ),
                            array(
                                'name' => 'StringTrim',
                            ),
                            array(
                                'name' => 'StringToUpper',
                            ),
                            array(
                                'name' => 'PregReplace',
                                'options' => array(
                                    'pattern' => '/[^a-zA-Z0-9_+]/',
                                    'replacement' => '-',
                                ),
                            ),
                        ),
                        'validators' => array(
                            array(
                                'name' => 'StringLength',
                                'options' => array(
                                    'encoding' => 'UTF-8',
                                    'min' => 1,
                                    'max' => 100
                                )
                            ),
                            array(
                                'name' => '\Zend\Validator\Db\NoRecordExists',
                                'options' => array(
                                    'table' => 'subjects',
                                    'field' => 'abbreviation',
                                    'exclude' => array(
                                        'field' => 'subjectID',
                                        'value' => $this->subjectID,
                                    ),
                                    'adapter' => $this->dbAdapter
                                )
                            ),
                        )
            ));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}