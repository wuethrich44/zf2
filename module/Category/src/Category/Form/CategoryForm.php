<?php

namespace Category\Form;

use Zend\Form\Form;

class CategoryForm extends Form {

    public function __construct($name = null) {
        parent::__construct('category');

        $this->add(array(
            'name' => 'categoryID',
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
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'class' => 'btn btn-default',
            ),
        ));
    }

}
