<?php

	//Api.php

	class API
	{
		private $connect = '';

		function __construct()
		{
			$this->database_connection();
		}

		function database_connection()
		{
			try {
				$this->connect = new PDO("mysql:host=localhost;dbname=kulina", "root", "");
			}
			catch (PDOException $e) {
				echo 'Connection failed: ' . $e->getMessage();
			}
		}

		function fetch_all()
		{
			$query = "SELECT * FROM user_review ORDER BY id";
			$statement = $this->connect->prepare($query);
			if($statement->execute())
			{
				while($row = $statement->fetch(PDO::FETCH_ASSOC))
				{
					$data[] = $row;
				}
				return $data;
			}
		}

		function insert()
		{
			if(isset($_POST["order_id"]))
			{
				$form_data = array(
					':order_id'		=>	$_POST['order_id'],
					':product_id'	=>	$_POST['product_id'],
					':user_id'		=>	$_POST['user_id'],
					':rating'		=>	$_POST['rating'],
					':review'		=>	$_POST['review']
				);
				$query = "
				INSERT INTO user_review 
				(order_id, product_id, user_id, rating, review, created_at, updated_at) VALUES 
				(:order_id, :product_id, :user_id, :rating, :review, CURDATE(), CURDATE())
				";
				$statement = $this->connect->prepare($query);
				if($statement->execute($form_data))
				{
					$data[] = array(
						'success'	=>	'1'
					);
				}
				else
				{
					$data[] = array(
						'success'	=>	'0'
					);
				}
			}
			else
			{
				$data[] = array(
					'success'	=>	'0'
				);
			}
			return $data;
		}

		function fetch_single($id)
		{
			$query = "SELECT * FROM user_review WHERE id='".$id."'";
			$statement = $this->connect->prepare($query);
			if($statement->execute())
			{
				foreach($statement->fetchAll() as $row)
				{
					$data['order_id'] = $row['order_id'];
					$data['product_id'] = $row['product_id'];
					$data['user_id'] = $row['user_id'];
					$data['rating'] = $row['review'];
					$data['review'] = $row['review'];
					$data['created_at'] = $row['created_at'];
					$data['updated_at'] = $row['updated_at'];
				}
				return $data;
			}
		}

		function update()
		{
			if(isset($_POST["order_id"]))
			{
				$form_data = array(
					':order_id'		=>	$_POST['order_id'],
					':product_id'	=>	$_POST['product_id'],
					':user_id'		=>	$_POST['user_id'],
					':rating'		=>	$_POST['rating'],
					':review'		=>	$_POST['review'],
					':id'			=>	$_POST['id']
				);
				$query = "
				UPDATE user_review 
				SET order_id = :order_id, product_id = :product_id, user_id = :user_id, rating = :rating, review = :review, updated_at = CURDATE() 
				WHERE id = :id
				";
				$statement = $this->connect->prepare($query);
				if($statement->execute($form_data))
				{
					$data[] = array(
						'success'	=>	'1'
					);
				}
				else
				{
					$data[] = array(
						'success'	=>	'0'
					);
				}
			}
			else
			{
				$data[] = array(
					'success'	=>	'0'
				);
			}
			return $data;
		}
		function delete($id)
		{
			$query = "DELETE FROM user_review WHERE id = '".$id."'";
			$statement = $this->connect->prepare($query);
			if($statement->execute())
			{
				$data[] = array(
					'success'	=>	'1'
				);
			}
			else
			{
				$data[] = array(
					'success'	=>	'0'
				);
			}
			return $data;
		}
	}

?>