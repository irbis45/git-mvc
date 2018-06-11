<?php

/**
 * Class FileUpload
 */
class FileUpload
{
	/**
	 * @var
	 */
	protected $file_attr;
	
	/**
	 * @var int
	 */
	protected $img_max_w = 320;
	
	/**
	 * @var int
	 */
	protected $img_max_h = 240;
	
	/**
	 * FileUpload constructor.
	 *
	 * @param $file
	 */
	public function __construct($file)
	{
		$this->file_attr = $file;
	}
	
	/**
	 * @return bool|string
	 * @throws \Gumlet\ImageResizeException
	 */
	public function upload_file()
	{
		
		if ($this->file_attr) {
			
			if ($this->file_attr['size'] > 500000) {
				return false;
			}
			
			if ( ! in_array($this->file_attr['type'], ['image/gif', 'image/png', 'image/jpg', 'image/jpeg'])) {
				return false;
			}
			
			$imageFormat = explode('.', $this->file_attr['name']);
			$imageFormat = $imageFormat[1];
			
			$file_name = '/images/' . hash('crc32', time()) . '.' . $imageFormat;
			$imagePath = $_SERVER['DOCUMENT_ROOT'] . '/images/' . hash('crc32', time()) . '.' . $imageFormat;
			$imageURL  = SERVER_URL . $file_name;
			$size_img  = getimagesize($this->file_attr['tmp_name']);
			
			
			if ($size_img[0] > $this->img_max_w || $size_img[1] > $this->img_max_h) {
				
				$image = new \Gumlet\ImageResize($this->file_attr['tmp_name']);
				$image->resize($this->img_max_w, $this->img_max_h);
				$image->save($imagePath);
				
				return $imageURL;
			}
			
			
			if (move_uploaded_file($this->file_attr['tmp_name'], $imagePath)) {
				return $imageURL;
			}
		}
		
		return false;
	}
}