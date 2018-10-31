<?php  

namespace Hcode\Model;

use \Hcode\DB\Sql;
use \Hcode\Model;
use \Hcode\Mailer;
use \Hcode\Model\User;

class Cart extends Model {

	const SESSION = "Cart";

	public static function getFromSession()
	{
		$cart = new Cart();

		if(isset($_SESSION[Cart::SESSION]) && (int)$_SESSION[Cart::SESSION][0]['idcart'] > 0){

			$cart->get((int)$_SESSION[Cart::SESSION]['idcart']);

		} else {

			$cart->getFromSessionID();

			if (!(int)$cart->getidcart() > 0){

				$data = [
					'dessessionid'=>session_id()
				];

				if (User::checkLogin(false)) {

					$user = User::getFromSession();

					$data['iduser'] = $user->getiduser();
				
				}

				$cart->setData($data);

				$cart->save();

				$cart->setToSession();

			}

		}

	return $cart;

	} //End Class getFromSesssion

	public function setToSession()
	{

		$_SESSION[Cart::SESSION] = $this->getValues();

	}//End Class setToSession

	public function getFromSessionID()
	{

		$sql = new Sql();
		
		$results = $sql->select("SELECT * FROM tb_carts WHERE dessessionid = :dessessionid", [
			':dessessionid'=>session_id()
		]);
		
		$this->setData($results[0]);
		

	} //End Class getFromSessionID

	public function get(int $idcart)
	{

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tc_carts WHERE idcart = :idcart", [
			':idcart'=>$idcart
		]);

		if(count($results) > 0) {

			$this->setData($results[0]);

		}

	} //End Class get
	
	public function save()
	{

		$sql = new Sql();

		$results = $sql->select("CALL sp_carts_save(:idcart, :dessessionid, :iduser, :deszicode, :vlfreight, :nrdays)", [
			':idcart'=>$this->getidcart(),
			':dessessionid'=>$this->getdessessionid(),
			':iduser'=>$this->getiduser(),
			':deszipcode'=>$this->getdeszipcode(),
			':vlfreight'=>$this->getvlfreight(),
			':nrdays'=>$this->getnrdays()
		]);

		$this->setData($results[0]);

	} // End class save
	
} // End class Cart
?>