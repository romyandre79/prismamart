<?php
class SiteController extends Controller {
	private $_identity;
	public $module = '';
	public function actionIndex() {
		parent::actionIndex();
    $this->pageTitle = getparameter('tagline');
    $this->description = getparameter('sitetitle').' '.getparameter('tagline');
    $this->render('index');
	}
	public function actionError() {
		$error = Yii::app()->errorHandler->error;
		if ($error) {
			$this->render('error', array('error' => $error));
		}
	}
	public function actionLogin() {
		if (isset($_POST['pptt']) && (isset($_POST['sstt']))) {
			$this->_identity = new UserIdentity($_POST['pptt'], $_POST['sstt']);
			$this->_identity->authenticate();
			if ($this->_identity->errorCode === UserIdentity::ERROR_NONE) {
				$rememberMe	 = isset($_POST['rrmm']) ? $_POST['rrmm'] : false;
				$duration		 = $rememberMe ? 3600 * 24 * 30 : 0; // 30 days
				Yii::app()->user->login($this->_identity, $duration);
				Yii::app()->db->createCommand("update useraccess set isonline = 1 where lower(username) = lower('".Yii::app()->user->id."')")->execute();
				getMessage('success', 'welcome');
			} else {
				getMessage('error', 'tryagain');
			}
		} else {
      Yii::app()->theme = "blue";
			$this->render('login');
		}
  }
  public function actionRegister() {
    if (Yii::app()->user->name != 'Guest') {
      $this->redirect(Yii::app()->createUrl('site/index'));
    } else {
      if (isset($_POST['regname']) && (isset($_POST['regpass']))) {
        if ($_POST['regname'] == '') {
          getmessage('error','usernameempty');
        } else 
        if ($_POST['regrealname'] == '') {
          getmessage('error','realnameempty');
        } else 
        if ($_POST['regpass'] == '') {
          getmessage('error','passempty');
        } else 
        if ($_POST['regemail'] == '') {
          getmessage('error','emailempty');
        } else 
        if ($_POST['regphoneno'] == '') {
          getmessage('error','phoneempty');
        } else {
          $sql = "select ifnull(count(1),0) 
            from useraccess a 
            where a.username = :username";
          $command = Yii::app()->db->createCommand($sql);
          $command->bindValue(':username',$_POST['regname'],PDO::PARAM_STR);
          $k = $command->queryScalar();
          if ($k > 0) {
            getmessage('error','usernameexist');
          } else {
            $connection = Yii::app()->db;
            $transaction=$connection->beginTransaction();
            try
            {
              $sql = "insert into useraccess (username,realname,password,email,phoneno,joindate,authkey,recordstatus)
              values (:username,:realname,:password,:email,:phoneno,now(),:authkey,:recordstatus)";
              $command = $connection->createCommand($sql);
              $command->bindValue(':username',$_POST['regname'],PDO::PARAM_STR);
              $command->bindValue(':realname',$_POST['regrealname'],PDO::PARAM_STR);
              $command->bindValue(':password',md5($_POST['regpass']),PDO::PARAM_STR);
              $command->bindValue(':email',$_POST['regemail'],PDO::PARAM_STR);
              $command->bindValue(':phoneno',$_POST['regphoneno'],PDO::PARAM_STR);
              $command->bindValue(':authkey',uniqid(),PDO::PARAM_STR);
              $command->bindValue(':recordstatus',1,PDO::PARAM_STR);
              $command->execute();

              $sql = "select last_insert_id()";
              $id = $connection->createCommand($sql)->queryScalar();

              $sql = "insert into addressbook (fullname,iscustomer,useraccessid,logo,picture,recordstatus)
                values (:fullname,:iscustomer,:useraccessid,:logo,:picture,:recordstatus)";
              $command = $connection->createCommand($sql);
              $command->bindValue(':fullname','Toko',PDO::PARAM_STR);  
              $command->bindValue(':iscustomer',1,PDO::PARAM_STR);  
              $command->bindValue(':useraccessid',$id,PDO::PARAM_STR);  
              $command->bindValue(':logo','default.jpg',PDO::PARAM_STR);  
              $command->bindValue(':picture','default.jpg',PDO::PARAM_STR);  
              $command->bindValue(':recordstatus',1,PDO::PARAM_STR);  
              $command->execute();

              $sql = "insert into usergroup (useraccessid,groupaccessid)
                values (:useraccessid,:groupaccessid)";
              $command = $connection->createCommand($sql);
              $command->bindValue(':useraccessid',$id,PDO::PARAM_STR);  
              $command->bindValue(':groupaccessid',4,PDO::PARAM_STR);  

              // todo send email 
              // todo send otp
              $transaction->commit();
              getmessage('success','datasaved');
            }
            catch(Exception $e)
            {
              $transaction->rollback();
              getmessage('error',$e->getMessage());
            }
          }
        }
      } else {
        $this->pageTitle = getparameter('tagline');
        $this->description = getparameter('sitetitle').' Register';
        $this->render('register');
      }
    }
	}
	public function actionLogout() {
		Yii::app()->db->createCommand("update useraccess set isonline = 0 where lower(username) = lower('".Yii::app()->user->id."')")->execute();
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->user->returnUrl);
	}
	public function actionSaveuser() {
		$connection	 = Yii::app()->db;
		$transaction = $connection->beginTransaction();
		try {
			if ($_POST['useraccessid'] > 0) {
				$sql = "update useraccess 
					set realname = '".$_POST['realname']."', 
					email = '".$_POST['email']."',
					phoneno = '".$_POST['phoneno']."',
					birthdate = '".$_POST['birthdate']."',
					useraddress = '".$_POST['useraddress']."' 
					where useraccessid = ".$_POST['useraccessid'];
				$connection->createCommand($sql)->execute();
				if ($_POST['password'] !== '') {
					$sql = "update useraccess 
						set password = md5('".$_POST['realname']."') 
						where useraccessid = ".$_POST['useraccessid'];
					$connection->createCommand($sql)->execute();
				}
			} else {
				$sql = "insert into useraccess (username,password,realname,email,phoneno,languageid,recordstatus,joindate,birthdate,useraddress) 
					values ('".$_POST['username']."',md5('".$_POST['password']."'),'".$_POST['realname']."','".$_POST['email']."',
					'".$_POST['phoneno']."',1,0,now(),'".$_POST['birthdate']."','".$_POST['useraddress']."')";
				$connection->createCommand($sql)->execute();
			}
			$transaction->commit();
			getMessage('success', 'alreadysaved');
		} catch (CdbException $e) {
			$transaction->rollBack();
			getMessage('error', $e->getMessage());
		}
	}
	public function actionGetProfile() {
		$username	 = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
		$password	 = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
		if (($username == '') && ($password == '')) {
			$user = Yii::app()->db->createCommand("select *
				from useraccess
				where lower(username) = '".Yii::app()->user->id."'")->queryRow();
		} else if (($username !== '') && ($password !== '')) {
			$user = Yii::app()->db->createCommand("select *
				from useraccess
				where lower(username) = '".$username."' and password = md5('".$password."')"
				)->queryRow();
		} else {
			echo CJSON::encode(array(
				'status' => 'failure',
				'div' => getCatalog('invaliduser')
			));
			Yii::app()->end();
		}
		echo CJSON::encode(array(
			'status' => 'success',
			'useraccessid' => $user['useraccessid'],
			'username' => $user['username'],
			'realname' => $user['realname'],
			'email' => $user['email'],
			'phoneno' => $user['phoneno'],
		));
		Yii::app()->end();
  }
  public function actionMaintain() {
    if (Yii::app()->params['ismaintain'] == true) {
      Yii::app()->theme = 'blue';
      $this->renderPartial('maintain');
    } else {
      $this->redirect('index');
    }
  }
}