<?php   

    class User
    {
        public $id;
        public $uname;
        public $mail;
        public $pwd;
		public $utype;

	

        public $error='';
		public $db;

        function __construct($pdo)
		{
			$this->db=$pdo;
			$this->init();
			
		}
        function init()
        {
            $this->id="";
            $this->uname="";
            $this->mail="";
			$this->utype="";
            $this->pwd="";
			
        }
		function empty_session()
		{
			$this->init();
			$_SESSION['id']=$this->id;
			$_SESSION['uname']=$this->uname;	
			$_SESSION['mail']=$this->mail;
			$_SESSION['pwd']=$this->pwd;
			$_SESSION['utype']=$this->utype;  
		}
        function crypt_pwd($pwd)
        {
            $pwd=md5($pwd);
            $pwd=addslashes($pwd);
            return $pwd;
        }
        function sanitize($txt)
        {
            $txt = htmlentities($txt);
			$txt = addslashes($txt);
			return $txt;
        }
        function confirm_pwrd($pwd,$c_pwrd)
		{
			if($pwd==$c_pwrd)
			{
				return true;
			}
			else
			{
				echo"<script>alert('Password Failed')</script>";

				return false;
			}
		}

        function connect_user($uname,$mail,$pwd,$remember_me)
		{
			$pwd=$this->sanitize($pwd);
			$pwd=$this->crypt_pwd($pwd);
			$mail=$this->sanitize($mail);
			/* echo"$pword et son email est $email"; */
			$req=$this->db->prepare("SELECT * FROM user WHERE (uname=? AND mail=? AND pwd=?)");
			try
			{
				$req->execute([$uname,$mail,$pwd]);
				$nb_lign = 0;
				$nb_lign = $req->rowCount();
				$curr_user = $req->fetch(PDO::FETCH_OBJ);	
				var_dump($nb_lign);
								
				if ($nb_lign > 0)
				{						
					$_SESSION['id']=$curr_user->id;
					$_SESSION['uname']=$curr_user->uname;
					$_SESSION['mail']=$curr_user->mail;
					$_SESSION['pwd']=$curr_user->pwd; 
					$_SESSION['utype']=$curr_user->utype;
 
					if($remember_me=true)
					{
						$_SESSION["temp_de_connexion"]=time();
					}
					
	
					return true;
				
				}
				else
				{
					echo"<script>alert('Aucun utilisateur correspondant')</script>";
					return false;
				}
			} catch (PDOException $e) {
				echo $e->getmessage();
				var_dump($this->error);
			}
			
		
		}

        function add_user($uname,$mail,$pwd,$utype,$c_pwrd)
		{
			$this->uname=$this->sanitize($uname);			
			$this->mail=$this->sanitize($mail);
			$this->utype=$utype;
			if ($this->confirm_pwrd($pwd,$c_pwrd)) 
			{
				$pwd=$this->sanitize($pwd);
				$this->pwd=$this->crypt_pwd($pwd);
				$req=$this->db->prepare("INSERT INTO user(uname,mail,pwd,utype) VALUES(?,?,?,?)");

				$succes=false;
				try
				{
					$succes=$req->execute([$this->uname,$this->mail,$this->pwd,$this->utype]);
					if($succes!=false)
						{

							return true;
						}
					else
						{
							return false;
						}
				}
				catch(PDOException $e)
				{
					$this->error=$e->getmessage();
					var_dump($this->error);
					return false;
				}
			}
			
			
			

			
		}
		function update_user($uname,$mail,$pword,$utype)
		{
			$this->name=$this->sanitize($uname);			
			$this->mail=$this->sanitize($mail);
			$this->$pwd=$this->sanitize($pwd);
			$this->pwd=$this->crypt_pwd($pwd);
			$this->utype=$utype;

			/* 
			$req = $db->prepare("CALL insert_tokens(? ,?, ?, NOW(), ?)"); */
			$req=$this->db->prepare("UPDATE user SET user(uname,mail,pwd,utype) VALUES(?,?,?,?)");

			$succes=false;
			try
			{
				$succes=$req->execute([$this->uname,$this->mail,$this->pwd,$this->utype]);
				if($succes!=false)
					{

						return true;
					}
				else
					{
						return false;
					}
			}
			catch(PDOException $e)
			{
				$this->error=$e->getmessage();
				var_dump($this->error);
				return false;
			}
		}
		function delete_user($id)
		{
			$r=$this->db->prepare("DELETE FROM user WHERE id=?");
			
			try
			{
				$req=$r->execute([$id]);
			}
			catch(PDOException $e)
			{
				$this->error=$e->getmessage();
				var_dump($this->error);
				return false;
			}
		}
		function total_utype($type)
		{
			$req=$this->db->prepare("SELECT * FROM user WHERE utype=?");
			try
			{

				$req->execute([$type]);
				$res=$req->fetchAll(PDO::FETCH_OBJ);
				$nb_lign = 0;
				$nb_lign = $req->rowCount();
				$_SESSION[$type]=$nb_lign;
				if($nb_lign>0)
				{
					return $res;
				}
				else
				{
					return false;
				}				
			}
			catch(PDOException $e)
			{
				$this->error=$e->getmessage();
				var_dump($this->error);
				return false;
			}
		}
		function total_users()
		{
			$req=$this->db->prepare("SELECT * FROM user");
			try
			{

				$req->execute();
				$result=$req->fetchAll(PDO::FETCH_OBJ);
				$nb_user = 0;
				$nb_user = $req->rowCount();
				$_SESSION['nb_users']=$nb_user;
				if($nb_user>0)
				{
					return $result;
				}
				else
				{
					return false;
				}
				
			}
			catch(PDOException $e)
			{
				$this->error=$e->getmessage();
				var_dump($this->error);
				return false;
			}
		}
		
    }

?>