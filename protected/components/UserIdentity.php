<?php
class UserIdentity extends CUserIdentity {
	const ERROR_USER_PASSWORD_INVALID = 3;
	public function authenticate() {
		$connection	 = Yii::app()->db;
    $sql				 = 'select a.username,a.realname,a.password,a.email,ifnull(count(1),0) as jumlah,a.languageid,b.languagename,a.phoneno,a.isonline,
        a.authkey, c.isvendor, c.iscustomer, c.logo, c.url, c.rating, c.picture, c.sexid, c.birthdate, d.sexname, c.fullname as shopname,
        c.buyertypeid, c.shoptypeid 
      from useraccess a
      join language b on b.languageid = a.languageid 
      left join addressbook c on c.useraccessid = a.useraccessid 
      left join sex d on d.sexid = c.sexid 
			where lower(username) = :username and password = md5(:password)';
		$command		 = $connection->createCommand($sql);
		$command->bindvalue(':username', $this->username, PDO::PARAM_STR);
		$command->bindvalue(':password', $this->password, PDO::PARAM_STR);
		$user				 = $command->queryRow();
		if ($user['jumlah'] > 0) {
      Yii::app()->user->useraccessid = $user['useraccessid'];
			Yii::app()->user->username = $user['username'];
			Yii::app()->user->realname = $user['realname'];
			Yii::app()->user->password = $user['password'];
			Yii::app()->user->email = $user['email'];
			Yii::app()->user->phoneno = $user['phoneno'];
			Yii::app()->user->languageid = $user['languageid'];
			Yii::app()->user->languagename = $user['languagename'];
			Yii::app()->user->isonline = $user['isonline'];
			Yii::app()->user->token = $user['authkey'];
			Yii::app()->user->isvendor = $user['isvendor'];
			Yii::app()->user->iscustomer = $user['iscustomer'];
			Yii::app()->user->iscustomer = $user['iscustomer'];
			Yii::app()->user->isvendor = $user['isvendor'];
			Yii::app()->user->url = $user['url'];
      Yii::app()->user->rating = $user['rating'];
      if (($user['picture'] == null) or ($user['picture'] == '')) {
        Yii::app()->user->picture = 'default.jpg';
      } else {
        Yii::app()->user->picture = $user['picture'];
      }
      if (($user['picture'] == null) or ($user['picture'] == '')) {
        Yii::app()->user->logo = 'default.jpg';
      } else {
        Yii::app()->user->logo = $user['logo'];
      }
			Yii::app()->user->sexid = $user['sexid'];
			Yii::app()->user->sexname = $user['sexname'];
			Yii::app()->user->birthdate = $user['birthdate'];
			Yii::app()->user->shopname = $user['shopname'];
			Yii::app()->user->buyertypeid = $user['buyertypeid'];
			Yii::app()->user->shoptypeid = $user['shoptypeid'];
			$this->errorCode = self::ERROR_NONE;
		} else {
			$this->errorCode = self::ERROR_USER_PASSWORD_INVALID;
		}
		return $this->errorCode == self::ERROR_NONE;
	}
}