<?php

namespace Category\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Validator\Db\NoRecordExists;
use Zend\Validator\Db\AbstractDb;
use Category\Form\CategoryForm;
use Category\Form\DeleteForm;

class CategoryController extends AbstractActionController
{

    protected $category;
    protected $categoryTable;

    /**
     * Show all categories
     *
     * (non-PHPdoc)
     * 
     * @see \Zend\Mvc\Controller\AbstractActionController::indexAction()
     */
    public function indexAction()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute('zfcuser');
        }

        return new ViewModel(array(
            'categories' => $this->getCategoryTable()->fetchAll()
        ));
    }

    /**
     * Add a new categorie
     *
     * @return ViewModel
     */
    public function addAction()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute('zfcuser');
        }

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

                return $this->redirect()->toRoute('category');
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
    public function editAction()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute('zfcuser');
        }

        $categoryID = (int) $this->params()->fromRoute('id', 0);
        if (!$categoryID) {
            return $this->redirect()->toRoute('category', array('action' => 'add'));
        }

        try {
            $category = $this->getCategoryTable()->getCategory($categoryID);
        } catch (\Exception $ex) {
            return $this->redirect()->toRoute('category', array('action' => 'index'));
        }

        $form = new CategoryForm();
        $form->bind($category);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($category->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getCategoryTable()->saveCategory($category);
                
                return $this->redirect()->toRoute('category');
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
    public function deleteAction()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute('zfcuser');
        }

        $categoryID = (int) $this->params()->fromRoute('id', 0);
        if (!$categoryID) {
            return $this->redirect()->toRoute('category');
        }

        $form = new DeleteForm();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $yes = $request->getPost('yes');
            $no = $request->getPost('no');

            if ($no == 'no') {
                return $this->redirect()->toRoute('category');
            }

            if ($yes == 'yes') {
                $categoryID = (int) $request->getPost('id');

                $form->setData($request->getPost());

                $validator = new NoRecordExists(array(
                    'table' => 'files',
                    'field' => 'categoryID',
                    'adapter' => $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter')
                ));
                $validator->setMessage(
                    "Please delete all files in this category",
                    AbstractDb::ERROR_RECORD_FOUND
                );

                $form->getInputFilter()->get('id')->getValidatorChain()->addValidator($validator);

                if ($form->isValid()) {
                    $this->getCategoryTable()->deleteCategory($categoryID);
                    return $this->redirect()->toRoute('category');
                }
            }
        }
        return array(
            'form' => $form,
            'id' => $categoryID,
            'category' => $this->getCategoryTable()->getCategory($categoryID)
        );
    }

    public function getCategory()
    {
        if (!$this->category) {
            $this->category = $this->getServiceLocator()->get('Category\Model\Category');
        }
        return $this->category;
    }

    public function getCategoryTable()
    {
        if (!$this->categoryTable) {
            $this->categoryTable = $this->getServiceLocator()->get('Category\Model\CategoryTable');
        }
        return $this->categoryTable;
    }
}
