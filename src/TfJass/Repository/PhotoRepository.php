<?php

	namespace TfJass\Repository;

	use Doctrine\DBAL\Connection;
	use TfJass\Vendor\ImageManipulator;
	use TfJass\Entity\Photo;

	class PhotoRepository implements RepositoryPhotoInterface
	{
		/*
		 * @var Doctrine\BAL\Connection
		 */
		protected $db;

		protected $upload_path;

		public function __construct(Connection $db, $path)
		{
			$this->db = $db;
			$this->upload_path = $path;
		}

		public function getPhotos()
		{
			$photos = $this->db->fetchAll('SELECT * FROM photos WHERE 1 ORDER BY year DESC');
			$tofs = array();
			$year = 0;
			foreach($photos as $photo){
				if($year!=$photo['year']){
					$year = $photo['year'];
				}
				$tofs[$year][] = $this->buildPhoto($photo);
			}
			return $tofs;
		}

		public function getMobilePhotos()
		{
			$photos = $this->db->fetchAll('SELECT * FROM photos WHERE 1 ORDER BY year DESC LIMIT 5');
			return $photos;
		}

		public function find($id)
		{
			$photoData = $this->db->fetchAssoc('SELECT * FROM photos WHERE id='.$id);
			$photo = $this->buildPhoto($photoData);
			return $photo;
		}

		public function deletePhoto(Photo $photo)
		{
			$this->db->delete('photos', array('id' => $photo->getId()));
		}

		public function savePhoto($data)
		{
			$this->db->insert('photos', array('titre' => $data->getTitre(), 'year' => $data->getYear(), 'name' => $data->getName()));
		}

		public function uploadPhoto($formData)
		{
			$fileupload = $formData->getFile();
			$exploded = explode('.', $fileupload->getClientOriginalName());
            $extension = end($exploded);
            $unique_id = md5(microtime());
            $destination = pathinfo($fileupload->getClientOriginalName(), PATHINFO_FILENAME) . $unique_id . '.' . $extension;
			$fileupload->move($this->upload_path, $destination);

			$this->cropAndResizePhoto($destination);

			$formData->setName($destination);
			$this->savePhoto($formData);
		}

		public function cropAndResizePhoto($photo_path)
		{

			$manipulator = new ImageManipulator($this->upload_path . $photo_path);
	        $min = min($manipulator->getWidth(), $manipulator->getHeight());
	        $x1 = $y1 = 0;
	        $x2 = $y2 = $min;
	        $manipulator->crop($x1, $y1, $x2, $y2);
	        $manipulator->resample(100, 100, true);
	        $manipulator->save($this->upload_path . 'R_' . $photo_path);
        }

        protected function buildPhoto($photoData)
		{
			$photo = new Photo();
			$photo->setId($photoData['id']);
			$photo->setName($photoData['name']);
			$photo->setYear($photoData['year']);
			$photo->setTitre($photoData['titre']);
			return $photo;
		}
	}
