<?php

namespace File\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\File\Transfer\Adapter\Http;
use Zend\Validator\File\Size;
use Zend\Validator\File\Extension;
use Zend\Filter\File\Rename;
use File\Model\File;
use File\Form\UploadForm;

class FileController extends AbstractActionController {

    protected $subjectTable;
    protected $categoryTable;
    protected $fileTable;
    protected $uploadPath;
    protected $maxFileSize;

    public function indexAction() {
        throw new \BadMethodCallException('Method not implemented');
    }

    public function addAction() {
        $form = new UploadForm();

        $optionSubject = $this->getSubjectTable()->getSubjectsForSelect();

        $form->get('subject')->setAttribute('options', $optionSubject);

        $optionCategory = $this->getCategoryTable()->getCategoriesForSelect();

        $form->get('category')->setAttribute('options', $optionCategory);

        $request = $this->getRequest();

        if ($request->isPost()) {
            $file = new File();

            $data = array_merge_recursive(
                    $this->getRequest()
                            ->getPost()
                            ->toArray(), $this->getRequest()
                            ->getFiles()
                            ->toArray());

            $form->setData($data);

            $uploadPath = $this->getFileUploadLocation();

            // Validatoren
            $size = new Size(
                    array(
                'max' => $this->getMaxFileSize()
            ));
            $extension = new Extension(array('zip', 'pdf'));

            // Filter für Zufallsnamen
            $filter = new Rename(
                    array(
                'target' => $uploadPath . '/file',
                'randomize' => true
            ));

            $adapter = new Http();
            $adapter->setValidators(
                    array(
                        $size,
                        $extension,
            ));
            $adapter->setFilters(
                    array(
                        $filter,
            ));

            if (!$adapter->isValid()) {
                $dataError = $adapter->getMessages();
                array_merge($dataError, $adapter->getErrors());
                foreach ($dataError as $key => $row) {
                    echo $row;
                }

                header('HTTP/1.1 500 Internal Server Error');
                exit();
            } else {

                $adapter->setDestination($uploadPath);

                if ($adapter->receive()) {
                    $subjectID = $data['subject'];
                    $categoryID = $data['category'];
                    $dbdata = array();
                    $dbdata['fileName'] = $data['file']['name'];
                    $filename = $adapter->getFileName();
                    if (is_array($filename)) {
                        $dbdata['url'] = basename(current($filename));
                    } else {
                        $dbdata['url'] = basename($filename);
                    }

                    $file->exchangeArray($dbdata);

                    $this->getFileTable()->saveFile($file, $subjectID, $categoryID);

                    header('HTTP/1.1 200 OK');
                    exit();
                }
            }
        }

        return array(
            'form' => $form
        );
    }

    public function editAction() {
        throw new \BadMethodCallException('Method not implemented');
    }

    /**
     * Delete the given file from disk and database
     *
     * @throws \Exception Could not delete file
     * @throws \InvalidArgumentException File not found
     * @return \Zend\Http\Response|null
     */
    public function deleteAction() {
        $fileID = (int) $this->params()->fromRoute('id', 0);
        $request = $this->getRequest();

        if ($fileID and $request->isXmlHttpRequest()) {
            try {

                $file = $this->getFileTable()->getFile($fileID);
                $path = $this->getFileUploadLocation() . '/' . $file->url;

                if (file_exists($path)) {
                    if (!unlink($path)) {
                        throw new \Exception('Could not delete file');
                    }
                }

                $this->getFileTable()->deleteFile($fileID);

                echo json_encode(array('state' => true));
                exit();
            } catch (\Exception $e) {
                echo json_encode(array('state' => false));
                exit();
            }
        }
    }

    public function getSubjectTable() {
        if (!$this->subjectTable) {
            $sm = $this->getServiceLocator();
            $this->subjectTable = $sm->get('Subject\Model\SubjectTable');
        }
        return $this->subjectTable;
    }

    public function getCategoryTable() {
        if (!$this->categoryTable) {
            $sm = $this->getServiceLocator();
            $this->categoryTable = $sm->get('File\Model\CategoryTable');
        }
        return $this->categoryTable;
    }

    public function getFileTable() {
        if (!$this->fileTable) {
            $sm = $this->getServiceLocator();
            $this->fileTable = $sm->get('File\Model\FileTable');
        }
        return $this->fileTable;
    }

    /**
     * Return the upload location
     *
     * @return string upload location
     */
    protected function getFileUploadLocation() {
        if (!$this->uploadPath) {
            // Fetch Configuration from Module Config
            $config = $this->getServiceLocator()->get('Config');
            $uploadPath = $config['module_config']['upload_location'];
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath);
            }
            $this->uploadPath = $uploadPath;
        }
        return $this->uploadPath;
    }

    /**
     * Return the upload location
     *
     * @return string upload location
     */
    protected function getMaxFileSize() {
        if (!$this->maxFileSize) {
            // Fetch Configuration from Module Config
            $config = $this->getServiceLocator()->get('Config');
            $this->maxFileSize = $config['module_config']['max_file_size'];
        }
        return $this->maxFileSize;
    }

}
