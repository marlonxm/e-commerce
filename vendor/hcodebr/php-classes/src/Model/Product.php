<?php  
namespace Hcode\Model;
use \Hcode\DB\Sql;
use \Hcode\Model;
use \Hcode\Mailer;



class Product extends Model {

	public static function listAll()
	{
		$sql = new Sql();
		return $sql->select("SELECT * FROM tb_products ORDER BY desproduct");
	} // End function listAll

	public function save() 
	{

		$sql = new Sql();
		$results = $sql->select("CALL sp_products_save(:idproduct, :desproduct, :vlprice, :vlwidth, :vlheight, :vllength, :vlweight, :desurl)", array(
			":idproduct"=>$this->getidproduct(),
			":desproduct"=>$this->getdesproduct(),
			":vlprice"=>$this->getvlprice(),
			":vlwidth"=>$this->getvlwidth(),
			":vlheight"=>$this->getvlheight(),
			":vllength"=>$this->getvllength(),
			":vlweight"=>$this->getvlweight(),
			":desurl"=>$this->getdesurl()
			

			));
		$this->setData($results[0]);

		
	}// End function Save

	public function get($idproduct)
	{

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_produtcs WHERE idproduct = :idproduct", [
			':idproduct'=>$idproduct
		]);

		$this->setData($results[0]);
	}// End function get

	public function delete()
	{

		$sql = new Sql();

		$sql->query("DELETE FROM tb_produtcs WHERE idproduct = :idproduct", [
			':idproduct'=>$this->getidproduct()
		]);

	}// End function Delete

	public function checkPhoto()
	{

		if (file_exists($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 
			"res" . DIRECTORY_SEPARATOR . 
			"site" . DIRECTORY_SEPARATOR . 
			"products" . DIRECTORY_SEPARATOR .
			$this->getidproduct() . ".jpg"
		)) {
			$url = "/res/site/img/products/" . $this->getidproduct(). ".jpg";
		
		}else{

			$url = "/res/site/img/products.jpg";
		}

		return $this->setdesphoto($url);

	}

	public function getValues()
	{

		$this->checkPhoto();
		
		$values = parent::getValues();

		return $values;

	}// End function getValues


			
} // End class Product
?>