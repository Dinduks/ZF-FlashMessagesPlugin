<?php

/**
 * @author  Samy Dindane <samy@dindane.com>
 * @link    https://github.com/Dinduks/ZF-FlashMessagesPlugin
 * @package ZF-FlashMessagesPlugin
 */
class Dinduks_Controller_Plugin_FlashMessages 
      extends Zend_Controller_Plugin_Abstract
{

    /**
     * @param Zend_Controller_Request_Abstract $request
     * @return array 
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $messages = Zend_Controller_Action_HelperBroker::
                getStaticHelper('FlashMessenger')->getMessages();

        foreach ($messages as &$message) {
            if (is_array($message)) {
                if (array_values($message) === $message) {
                    $message = array('' => $message[key($message)]);
                }
            } else if (is_string($message)) {
                $message = array('' => $message);
            } else {
                throw new Exception(
                    "Flash messages can be arrays and strings only! \n
                     '$message' is not a valid value."
                );
            }

            $viewRenderer = Zend_Controller_Action_HelperBroker::
                    getStaticHelper('viewRenderer');
            $viewRenderer->init();
            $viewRenderer->view->flashMessages = $messages;
        }
        
        return $messages;
    }

}
