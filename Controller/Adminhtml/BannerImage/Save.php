<?php
namespace Ksolves\ImageSlider\Controller\Adminhtml\BannerImage;
use Magento\Backend\App\Action;
use Magento\Backend\Model\Session;
use Ksolves\ImageSlider\Model\BannerImage;

class Save extends \Magento\Backend\App\Action
{
   
    protected $bannerImageModel;
    protected $imageUploader;
    protected $adminsession;
    /**
     * @param Action\Context $context
     * @param BannerImage    $bannerImageModel
     * @param Session        $adminsession
     */
    public function __construct(
        Action\Context $context,
        BannerImage $bannerImageModel,
        Session $adminsession,
        \Magento\Catalog\Model\ImageUploader $imageUploader,
    ) {
        parent::__construct($context);
        $this->bannerImageModel = $bannerImageModel;
        $this->adminsession = $adminsession;
        $this->imageUploader = $imageUploader;
    }
    /**
     * Save blog record action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
                try{
                if (isset($data['path'][0]['name']) && isset($data['path'][0]['tmp_name'])) {
                    $this->imageUploader->moveFileFromTmp($data['path'][0]);
                    $data['path'] =$data['path'][0]['name'];
                } elseif (isset($data['path'][0]['name']) && !isset($data['path'][0]['tmp_name'])) {
                    $data['path'] = $data['path'][0]['name'];
                } else {
                    $data['path'] = null;
                }
                $this->bannerImageModel->setData($data);
                $this->bannerImageModel->save();
                $this->messageManager->addSuccess(__('The data has been saved.'));
                $this->adminsession->setFormData(false);
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the data.'));
            }
        }
        
        return $resultRedirect->setPath('*/*/index');
    }
}