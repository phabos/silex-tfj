<?php

	namespace TfJass\Repository;

	use Doctrine\DBAL\Connection;
	use TfJass\Entity\Concert;
	
	class ConcertRepository implements RepositoryConcertInterface
	{
		protected $db;
		
		public function __construct(Connection $db)
		{
			$this->db = $db;
		}

		public function getConcertById($concert_id)
		{
			$concertData = $this->db->fetchAssoc('SELECT * FROM concerts WHERE id = "'.$concert_id.'"');
			$concert = $this->buildConcert($concertData);
			return $concert;	
		}

		public function getConcert()
		{
			$concertData = $this->db->fetchAssoc('SELECT * FROM concerts WHERE datec >= "'.date('Y-m-d').'" ORDER BY datec ASC');
			$concert = $this->buildConcert($concertData);
			return $concert;
		}

		public function find($id)
		{
			$concertData = $this->db->fetchAssoc('SELECT * FROM concerts WHERE id='.$id);
			$concert = $this->buildConcert($concertData);
			return $concert;
		}

		public function getAllConcert($limit = 5)
		{
			$concertData = $this->db->fetchAll('SELECT * FROM concerts WHERE datec >= "'.date('Y-m-d').'" ORDER BY datec ASC LIMIT '.$limit);
			$concerts = array();
			foreach ($concertData as $c) {
			    $concerts[] = $this->buildConcert($c);
			}
			return $concerts;
		}

		public function deleteConcert(Concert $concert)
		{
			$this->db->delete('concerts', array('id' => $concert->getId()));
		}

		public function addConcert($data)
		{
			$this->db->insert('concerts', array('datec' => $data->getDatec()->format('Y-m-d'), 'lieu' => $data->getLieu(), 'prix' => $data->getPrix(), 'heure' => $data->getHeure()->format('H:i:s'), 'gmaps' => $data->getGmaps()));
		}

		public function modifyConcert($data)
		{
			$this->db->update('concerts', array('datec' => $data->getDatec()->format('Y-m-d'), 'lieu' => $data->getLieu(), 'prix' => $data->getPrix(), 'heure' => $data->getHeure()->format('H:i:s'), 'gmaps' => $data->getGmaps()), array('id' => $data->getId()));	
		}

		protected function buildConcert($concertData)
		{
			$concert = new Concert();
			$concert->setId($concertData['id']);
			$concert->setDatec($concertData['datec']);
			$concert->setLieu($concertData['lieu']);
			$concert->setPrix($concertData['prix']);
			$concert->setHeure($concertData['heure']);
			$concert->setGmaps($concertData['gmaps']);
			return $concert;
		}
	}