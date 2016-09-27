<?php

	namespace TfJass\Repository;

	use Doctrine\DBAL\Connection;
	use TfJass\Entity\Email;

	class EmailRepository implements RepositoryEmailInterface
	{

		protected $db;

		public function __construct(Connection $db)
		{
			$this->db = $db;
		}

		public function findByEmail($email)
		{
			$sql = "SELECT count(email) FROM newsletters WHERE email = :email";
    		$emails = $this->db->fetchArray($sql, array('email' => $email));
    		return ($emails[0] ? 1 : 0);
		}

		public function saveEmail($email)
		{
			$this->db->insert('newsletters', array('email' => $email));
		}

		public function getAllEmail()
		{
    		$emailData = $this->db->fetchAll("SELECT * FROM newsletters WHERE 1");
    		foreach($emailData as $email)
    		{
    			$emails[] = $this->buildEmail($email);
    		}
    		return $emails;
		}

		public function addEmail($email)
		{
			if($this->findByEmail($email)){
				return array('error' => '1', 'msg' => 'Votre email est déjà inscrit !');
			}else{
				$this->saveEmail($email);
				return array('error' => '', 'msg'=>'Votre email est inscrit');
			}
		}

		protected function buildEmail($emailData)
		{
			$email = new Email();
			$email->setId($emailData['id']);
			$email->setEmail($emailData['email']);
			return $email;
		}
	}
