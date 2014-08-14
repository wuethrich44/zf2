<?php

namespace Subject\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Validator\Db\NoRecordExists;
use Subject\Form\SubjectForm;
use Subject\Form\DeleteForm;

class SubjectController extends AbstractActionController {

    protected $subject;
    protected $subjectTable;

    public function indexAction() {
        $paginator = $this->getSubjectTable()->fetchAll(true);
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
        $paginator->setItemCountPerPage(10);

        return new ViewModel(array(
            'paginator' => $paginator
        ));
    }

    /**
     * Add a new subject
     *
     * @return ViewModel
     */
    public function addAction() {
        $form = new SubjectForm();
        $form->get('submit')->setLabel('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $subject = $this->getSubject();
            $form->setInputFilter($subject->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $subject->exchangeArray($form->getData());
                $this->getSubjectTable()->saveSubject($subject);

                return $this->redirect()->toRoute('zfcadmin/subject');
            }
        }
        return array(
            'form' => $form
        );
    }

    /**
     * Edit a subject
     *
     * @return ViewModel
     */
    public function editAction() {
        $subjectID = (int) $this->params()->fromRoute('id', 0);
        if (!$subjectID) {
            return $this->redirect()->toRoute('zfcadmin/subject', array(
                        'action' => 'add'
            ));
        }

        try {
            $subject = $this->getSubjectTable()->getSubject($subjectID);
        } catch (\Exception $ex) {
            return $this->redirect()->toRoute('zfcadmin/subject', array(
                        'action' => 'index'
            ));
        }

        $form = new SubjectForm();
        $form->bind($subject);
        $form->get('submit')->setLabel('Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($subject->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getSubjectTable()->saveSubject($subject);

                // Redirect to list of subjects
                return $this->redirect()->toRoute('zfcadmin/subject');
            }
        }

        return array(
            'id' => $subjectID,
            'form' => $form
        );
    }

    /**
     * Delete a subject
     *
     * @return ViewModel
     */
    public function deleteAction() {
        $subjectID = (int) $this->params()->fromRoute('id', 0);
        if (!$subjectID) {
            return $this->redirect()->toRoute('zfcadmin/subject');
        }

        $form = new DeleteForm();

        $request = $this->getRequest();

        if ($request->isPost()) {
            $yes = $request->getPost('yes');
            $no = $request->getPost('no');

            if ($no == 'no') {
                // Redirect to list of subjects
                return $this->redirect()->toRoute('zfcadmin/subject');
            }

            if ($yes == 'yes') {
                $subjectID = (int) $request->getPost('id');

                $form->setData($request->getPost());

                $validator = new NoRecordExists(
                        array(
                    'table' => 'files',
                    'field' => 'subjectID',
                    'adapter' => $this->getServiceLocator()->get(
                            'Zend\Db\Adapter\Adapter')
                ));
                $validator->setMessage("Please delete all files in this subject", \Zend\Validator\Db\AbstractDb::ERROR_RECORD_FOUND);

                $form->getInputFilter()->get('id')->getValidatorChain()->addValidator($validator);

                if ($form->isValid()) {
                    $this->getSubjectTable()->deleteSubject($subjectID);
                    // Redirect to list of categories
                    return $this->redirect()->toRoute('zfcadmin/subject');
                }
            }
        }

        return array(
            'form' => $form,
            'id' => $subjectID,
            'subject' => $this->getSubjectTable()->getSubject($subjectID)
        );
    }

    public function getSubject() {
        if (!$this->subject) {
            $sm = $this->getServiceLocator();
            $this->subject = $sm->get('Subject');
        }
        return $this->subject;
    }

    public function getSubjectTable() {
        if (!$this->subjectTable) {
            $sm = $this->getServiceLocator();
            $this->subjectTable = $sm->get('Subject\Model\SubjectTable');
        }
        return $this->subjectTable;
    }

}
