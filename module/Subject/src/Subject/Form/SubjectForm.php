<?php

namespace Subject\Form;

use Zend\Form\Form;

class SubjectForm extends Form {

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('subject');

        $this->add(array(
            'name' => 'subjectID',
            'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'name',
            'type' => 'Text',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Name',
            ),
        ));
        $this->add(array(
            'name' => 'abbreviation',
            'type' => 'Text',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Abbreviation',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'class' => 'btn btn-default',
            ),
        ));
    }

}
