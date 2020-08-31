<?php
namespace system;
interface Router {
    /**
     * Request Hndler by query params or Request URI
     * @abstract
     * @param \system\WebApplication $aplication
     * @return boolean   true if handler is last false if continue
     * @throws Exception if handler rror
     */
    public function handler(WebApplication $aplication);
    
}