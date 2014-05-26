<?php

namespace File\Form;

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
                    'type' => 'Submit',
                    'attributes' => array(
                        'value' => 'yes',
                        'class' => 'btn btn-default'
                    )
        ));

        $this->add(
                array(
                    'name' => 'no',
                    'type' => 'Submit',
                    'attributes' => array(
                        'value' => 'no',
                        'class' => 'btn btn-default'
                    )
        ));
    }

}
