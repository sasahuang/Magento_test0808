<?php
class AYG_Slider_Adminhtml_SlideController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('slider/slidermanager')
            ->_addBreadcrumb(
                Mage::helper('slider')->__('Slider Manager'),
                Mage::helper('slider')->__('Slider Manager')
            );
        return $this;
    }
    
    public function indexAction()
    {
        $this->_initAction()->renderLayout();
    }
    
    public function editAction()
    {
        $id     = $this->getRequest()->getParam('id');
        $model  = Mage::getModel('slider/slide')->load($id);
        
        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            
            if (!empty($data)) {
                $model->setData($data);
            }
            
            if ($model->getId() && $model->getImgSrc()) {
                $model->setImgSrc(Mage::helper('slider')->getImageRelativeUrl($model->getImgSrc()));
            }
            
            Mage::register('slide_data', $model);
            
            $this->loadLayout();
            $this->_setActiveMenu('slider/items');
            
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
            
            $this->_addContent($this->getLayout()->createBlock('slider/adminhtml_slide_edit'))
                ->_addLeft($this->getLayout()->createBlock('slider/adminhtml_slide_edit_tabs'));
            
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('slider')->__('Item does not exist'));
            $this->_redirect('*/*/');
        }
    }
    
    public function newAction()
    {
        $this->_forward('edit');
    }
    
    public function saveAction()
    {
        $data = $this->getRequest()->getPost();
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            $model = Mage::getModel('slider/slide')->load($id);
            if (!$model || !$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Unable to find item to save'));
                return $this->_redirect('*/*/');
            }
        }
        if ($data) {
            $model = Mage::getModel('slider/slide')->load($id);
            $remove     = isset($data['img_src']['delete']) ? $data['img_src']['delete'] : 0;
            $new        = !empty($_FILES['img_src']['name']);
            $oldName    = $model->getImgSrc();
            unset($data['img_src']);
            
            $model = Mage::getModel('slider/slide');
            $model->setData($data)->setId($id);
            
            try {
                $model->save();
                
                if ($model->getId()) {
                    $path   = Mage::helper('slider')->getImagesUploadDir();
                    try {
                        if ($remove || $new) {
                            if ($oldName) {
                                @unlink($path . $oldName);
								
								$oldResizeName = 'slider' . $model->getId();
								$oldResizeType = '.' . strtolower(substr(strrchr($oldName, '.'), 1));
								
								@unlink($path . $oldResizeName.'_480'.$oldResizeType);
								@unlink($path . $oldResizeName.'_720'.$oldResizeType);
								@unlink($path . $oldResizeName.'_1024'.$oldResizeType);
								@unlink($path . $oldResizeName.'_1280'.$oldResizeType);
                            }
                            $model->setImgSrc('');
                        }
                        if ($new) {
                            $newName = 'slider' . $model->getId();
                            $newName .= '.' . strtolower(substr(strrchr($_FILES['img_src']['name'], '.'), 1));
                            
                            $uploader = new Varien_File_Uploader('img_src');
                            $uploader->setFilesDispersion(false);
                            $uploader->setAllowRenameFiles(false);
                            $uploader->setAllowedExtensions(array('png', 'gif', 'jpg', 'jpeg'));
                            $uploader->save($path, $newName);
                            
                            $model->setImgSrc($newName);
							
							$resizeName = 'slider' . $model->getId();
							$resizetype = '.' . strtolower(substr(strrchr($_FILES['img_src']['name'], '.'), 1));
							
							$imageObj = new Varien_Image($path.$newName);
							$imageObj->keepAspectRatio(TRUE);
							$imageObj->keepFrame(TRUE);
							$imageObj->backgroundColor(array(255,255,255));
							$imageObj->resize(480,150);
							$imageObj->quality(100);
							$imageObj->save($path.$resizeName.'_480'.$resizetype);
							
							$imageObj = new Varien_Image($path.$newName);
							$imageObj->keepAspectRatio(TRUE);
							$imageObj->keepFrame(TRUE);
							$imageObj->backgroundColor(array(255,255,255));
							$imageObj->resize(720,225);
							$imageObj->quality(100);
							$imageObj->save($path.$resizeName.'_720'.$resizetype);
							
							$imageObj = new Varien_Image($path.$newName);
							$imageObj->keepAspectRatio(TRUE);
							$imageObj->keepFrame(TRUE);
							$imageObj->backgroundColor(array(255,255,255));
							$imageObj->resize(1024,320);
							$imageObj->quality(100);
							$imageObj->save($path.$resizeName.'_1024'.$resizetype);
							
							$imageObj = new Varien_Image($path.$newName);
							$imageObj->keepAspectRatio(TRUE);
							$imageObj->keepFrame(TRUE);
							$imageObj->backgroundColor(array(255,255,255));
							$imageObj->resize(1280,400);
							$imageObj->quality(100);
							$imageObj->save($path.$resizeName.'_1280'.$resizetype);

                        }
                        if ($remove || $new) {
                            $model->save();
                        }
                    } catch (Exception $e) {
                        Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                    }
                }
                
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
    }
    
    public function deleteAction()
    {
        $id = $this->getRequest()->getParam('id');
        if ($id > 0) {
            try {
                $model = Mage::getModel('slider/slide');
                $model->setId($id)->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $id));
            }
        }
        $this->_redirect('*/*/');
    }
    
    public function massDeleteAction()
    {
        $slideIds = $this->getRequest()->getParam('slide');
        if (!is_array($slideIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($slideIds as $slideId) {
                    $slide = Mage::getModel('slider/slide')->load($slideId);
                    $slide->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($slideIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
    
    public function massStatusAction()
    {
        $slideIds = $this->getRequest()->getParam('slide');
        if (!is_array($slideIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($slideIds as $slideId) {
                    $slide = Mage::getSingleton('slider/slide')
                        ->load($slideId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($slideIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
    
    public function exportCsvAction()
    {
        $fileName   = 'slider.csv';
        $content    = $this->getLayout()->createBlock('slider/adminhtml_slide_grid')->getCsv();
        $this->_sendUploadResponse($fileName, $content);
    }
    
    public function exportXmlAction()
    {
        $fileName = 'slider.xml';
        $content = $this->getLayout()->createBlock('slider/adminhtml_slide_grid')->getXml();
        $this->_sendUploadResponse($fileName, $content);
    }
    
    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }
}
