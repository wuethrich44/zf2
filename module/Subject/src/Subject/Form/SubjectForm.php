<?php

namespace Subject\Form;

use Zend\Form\Form;

class SubjectForm extends Form {

    public function __construct($name = null) {
        parent::__construct('subject');

        $this->add(array(
            'name' => 'subjectID',
            'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'name',
            'type' => 'text',
            'attributes' => array('id' => 'name',),
            'options' => array('label' => 'Name',),
        ));
        $this->add(array(
            'name' => 'abbreviation',
            'type' => 'text',
            'attributes' => array('id' => 'abbreviation',),
            'options' => array('label' => 'Abbreviation',),
        ));
        $this->add(array(
            'name' => 'submit',
            'type' => 'button',
            'attributes' => array('type' => 'submit',),
            'options' => array('label' => 'Go',),
        ));
    }

}
