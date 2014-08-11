<?php

namespace Subject\Form;

use Zend\Form\Form;

class DeleteForm extends Form {

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('delete');

        $this->add(
                array(
                    'name' => 'id',
                    'type' => 'Hidden'
        ));

        $this->add(
                array(
                    'name' => 'yes',
                    'type' => 'Button',
                    'attributes' => array(
                        'type' => 'submit',
                        'value' => 'yes',
                    ),
                    'options' => array('label' => 'Yes',),
        ));

        $this->add(
                array(
                    'name' => 'no',
                    'type' => 'Button',
                    'attributes' => array(
                        'type' => 'submit',
                        'value' => 'no',
                    ),
                    'options' => array('label' => 'No',),
        ));
    }

}
