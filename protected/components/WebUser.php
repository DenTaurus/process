<?php

class WebUser extends CWebUser {

    private $_model = null;

    function getRole() {
        if ($user = $this->getModel()) {
            // в таблице User есть поле role
            return ($user->isadmin == 1) ? 'administrator' : 'user';
        }
    }

    private function getModel() {
        
        if (!$this->isGuest && $this->_model === null) {
            $this->_model = Users::model()->findByPk($this->id, array('select' => 'isadmin'));
        }
        return $this->_model;
    }

}
