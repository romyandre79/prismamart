<?php
class WebUser extends CWebUser {
  private $_model;
  public function getUseraccessid() {
		return $this->getState('__useraccessid');
  }
  
  public function setUseraccessid($value) {
		$this->setState('__useraccessid',$value);
	}

  public function getUsername() {
		return $this->getState('__username');
  }
  
  public function setUsername($value) {
		$this->setState('__username',$value);
	}

  public function getRealname() {
		return $this->getState('__realname');
  }
  
  public function setRealname($value) {
		$this->setState('__realname',$value);
	}

  public function getPassword() {
		return $this->getState('__password');
  }
  
  public function setPassword($value) {
		$this->setState('__password',$value);
	}

  public function getEmail() {
		return $this->getState('__email');
  }
  
  public function setEmail($value) {
		$this->setState('__email',$value);
	}

  public function getPhoneno() {
		return $this->getState('__phoneno');
  }
  
  public function setPhoneno($value) {
		$this->setState('__phoneno',$value);
	}

  public function getLanguageid() {
		return $this->getState('__languageid');
  }
  
  public function setLanguageid($value) {
		$this->setState('__languageid',$value);
	}

  public function getLanguagename() {
		return $this->getState('__languagename');
  }
  
  public function setLanguagename($value) {
		$this->setState('__languagename',$value);
	}

  public function getToken() {
		return $this->getState('__token');
  }
  
  public function setToken($value) {
		$this->setState('__token',$value);
	}

  public function getIsonline() {
    return $this->getState('__isonline');
  }

  public function setIsonline($value){
    return $this->setState('__isonline',$value);
  }

  public function getSexid() {
    return $this->getState('__sexid');
  }

  public function setSexid($value){
    return $this->setState('__sexid',$value);
  }

  public function getLogo() {
    return $this->getState('__logo');
  }

  public function setLogo($value){
    return $this->setState('__logo',$value);
  }

  public function getSexname() {
    return $this->getState('__sexname');
  }

  public function setSexname($value){
    return $this->setState('__sexname',$value);
  }

  public function getPicture() {
    return $this->getState('__picture');
  }

  public function setPicture($value){
    return $this->setState('__picture',$value);
  }

  public function getUrl() {
    return $this->getState('__url');
  }

  public function setUrl($value){
    return $this->setState('__url',$value);
  }

  public function getIsCustomer() {
    return $this->getState('__iscustomer');
  }

  public function setIsCustomer($value){
    return $this->setState('__iscustomer',$value);
  }

  public function getIsVendor() {
    return $this->getState('__isvendor');
  }

  public function setIsVendor($value){
    return $this->setState('__isvendor',$value);
  }

  public function getRating() {
    return $this->getState('__rating');
  }

  public function setRating($value){
    return $this->setState('__rating',$value);
  }

  public function getBirthdate() {
    return $this->getState('__birthdate');
  }

  public function setBirthdate($value){
    return $this->setState('__birthdate',$value);
  }

  public function getShopname() {
    return $this->getState('__shopname');
  }

  public function setShopname($value){
    return $this->setState('__shopname',$value);
  }

  public function getBuyerTypeID() {
    return $this->getState('__buyertypeid');
  }

  public function setBuyerTypeID($value){
    return $this->setState('__buyertypeid',$value);
  }

  public function getShopTypeID() {
    return $this->getState('__shoptypeid');
  }

  public function setShopTypeID($value){
    return $this->setState('__shoptypeid',$value);
  }

}