<?php
namespace Ksolves\ImageSlider\Controller\Adminhtml\Banner;
use Magento\Backend\App\Action;
use Magento\Backend\Model\Session;
use Ksolves\ImageSlider\Model\Banner;

class Save extends \Magento\Backend\App\Action
{
    /*
     * @var Blog
     */
    protected $bannermodel;
    /**
     * @var Session
     */
    protected $adminsession;
    /**
     * @param Action\Context $context
     * @param Banner         $bannermodel
     * @param Session        $adminsession
     */
    public function __construct(
        Action\Context $context,
        Banner $bannermodel,
        Session $adminsession,
    ) {
        parent::__construct($context);
        $this->bannermodel = $bannermodel;
        $this->adminsession = $adminsession;
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
            $this->bannermodel->setData($data);
            try {
                $this->bannermodel->save();
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