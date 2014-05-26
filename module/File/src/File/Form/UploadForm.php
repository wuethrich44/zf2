<?php

namespace File\Form;

use Zend\Form\Form;

class UploadForm extends Form {

    public function __construct($name = null) {
        parent::__construct('Upload');

        // Damit Fileupload mit jQuery funktioniert
        $this->setAttribute('data-ajax', 'false');
        $this->setAttribute('class', 'dropzone');

        $this->add(
                array(
                    'name' => 'subject',
                    'type' => 'Zend\Form\Element\Select',
                    'attributes' => array(
                        'class' => 'form-control',
                        'id' => 'subject',
                    ),
                    'options' => array(
                        'label' => 'Modul'
                    )
        ));

        $this->add(
                array(
                    'name' => 'category',
                    'type' => 'Zend\Form\Element\Select',
                    'attributes' => array(
                        'class' => 'form-control',
                        'id' => 'category',
                    ),
                    'options' => array(
                        'label' => 'Kategorie'
                    )
        ));
    }

}
