<?php

namespace Category\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Validator\Db\NoRecordExists;
use Category\Form\CategoryForm;
use Category\Form\DeleteForm;

class CategoryController extends AbstractActionController {

    protected $category;
    protected $categoryTable;

    /**
     * Show all categories
     *
     * (non-PHPdoc)
     * 
     * @see \Zend\Mvc\Controller\AbstractActionController::indexAction()
     */
    public function indexAction() {
        return new ViewModel(
                array(
            'categories' => $this->getCategoryTable()->fetchAll()
        ));
    }

    /**
     * Add a new categorie
     *
     * @return ViewModel
     */
    public function addAction() {
        $form = new CategoryForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $category = $this->getCategory();
            $form->setInputFilter($category->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $category->exchangeArray($form->getData());
                $this->getCategoryTable()->saveCategory($category);

                return $this->redirect()->toRoute('zfcadmin/category');
            }
        }
        return array(
            'form' => $form
        );
    }

    /**
     * Edit a category
     *
     * @return ViewModel
     */
    public function editAction() {
        $categoryID = (int) $this->params()->fromRoute('id', 0);
        if (!$categoryID) {
            return $this->redirect()->toRoute('zfcadmin/category', array(
                        'action' => 'add'
            ));
        }

        try {
            $category = $this->getCategoryTable()->getCategory($categoryID);
        } catch (\Exception $ex) {
            return $this->redirect()->toRoute('zfcadmin/category', array(
                        'action' => 'index'
            ));
        }

        $form = new CategoryForm();
        $form->bind($category);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($category->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                // FIXME check if name already exists
                $this->getCategoryTable()->saveCategory($category);

                // Redirect to list of categories
                return $this->redirect()->toRoute('zfcadmin/category');
            }
        }

        return array(
            'id' => $categoryID,
            'form' => $form
        );
    }

    /**
     * Delete a category
     *
     * @return ViewModel
     */
    public function deleteAction() {
        $categoryID = (int) $this->params()->fromRoute('id', 0);
        if (!$categoryID) {
            return $this->redirect()->toRoute('zfcadmin/category');
        }

        $form = new DeleteForm();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $yes = $request->getPost('yes');
            $no = $request->getPost('no');

            if ($no == 'no') {
                // Redirect to list of categories
                return $this->redirect()->toRoute('zfcadmin/category');
            }

            if ($yes == 'yes') {
                $categoryID = (int) $request->getPost('id');

                $form->setData($request->getPost());

                $validator = new NoRecordExists(
                        array(
                    'table' => 'files',
                    'field' => 'categoryID',
                    'adapter' => $this->getServiceLocator()->get(
                            'Zend\Db\Adapter\Adapter')
                ));
                $validator->setMessage("Please delete all files in this category", \Zend\Validator\Db\AbstractDb::ERROR_RECORD_FOUND);

                $form->getInputFilter()->get('id')->getValidatorChain()->addValidator($validator);

                if ($form->isValid()) {
                    $this->getCategoryTable()->deleteCategory($categoryID);
                    // Redirect to list of categories
                    return $this->redirect()->toRoute('zfcadmin/category');
                }
            }
        }
        return array(
            'form' => $form,
            'id' => $categoryID,
            'category' => $this->getCategoryTable()->getCategory(
                    $categoryID)
        );
    }

    public function getCategory() {
        if (!$this->category) {
            $sm = $this->getServiceLocator();
            $this->category = $sm->get('Category');
        }
        return $this->category;
    }

    public function getCategoryTable() {
        if (!$this->categoryTable) {
            $sm = $this->getServiceLocator();
            $this->categoryTable = $sm->get('Category\Model\CategoryTable');
        }
        return $this->categoryTable;
    }

}
