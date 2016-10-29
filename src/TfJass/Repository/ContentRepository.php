<?php

	namespace TfJass\Repository;

	use Doctrine\DBAL\Connection;
	use TfJass\Entity\Content;
	
	class ContentRepository implements RepositoryContentInterface
	{

		protected $db;
		public static $content_urls = array('Page d\'acceuil' => 'accueil', 'Page Bio' => 'biographie');

		public function __construct(Connection $db)
		{
			$this->db = $db;
		}

		public function getContent($page)
		{
			$contentData = $this->db->fetchAssoc('SELECT * FROM contents WHERE url = ?', array($page));
			$content = $this->buildContent($contentData);
			return $content;
		}

		public function getContentUrls()
		{
			return self::$content_urls;
		}

		public function addContent($data)
		{
			$this->db->update('contents', array('titre' => $data->getTitre(), 'url' => $data->getUrl(), 'content' => $data->getContent()), array('id' => $data->getId()));
		}

		protected function buildContent($contentData)
		{
			$content = new Content();
			$content->setId($contentData['id']);
			$content->setTitre($contentData['titre']);
			$content->setUrl($contentData['url']);
			$content->setContent($contentData['content']);
			return $content;
		}
	}