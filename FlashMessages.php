<?php

class Dinduks_Controller_Plugin_FlashMessage extends Zend_Controller_Plugin_Abstract
{

    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $messages = Zend_Controller_Action_HelperBroker::
                getStaticHelper('FlashMessenger')->getMessages();

        if (!empty($messages)) {
            foreach ($messages as &$message) {
                if (is_array($message)) {
                    if (array_values($message) === $message) {
                        $message = array('' => $message[key($message)]);
                    }
                } else {
                    $message = array('' => $message);
                }
            }

            $viewRenderer = Zend_Controller_Action_HelperBroker::
                    getStaticHelper('viewRenderer');
            $viewRenderer->init();
            $viewRenderer->view->flashMessages = $messages;
        }
    }

}
