<?php

class Company extends user {
    public function __construct()
    {
        parent::__construct();
        $this->config->userTableName = 'Company';
        // Start object construction
        $this->start();
    }
}
?>
