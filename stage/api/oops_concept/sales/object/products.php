<?php
class Products{

	private $conn;
	// public $distributor_token;

	public function __construct($db){
        $this->conn = $db;
    }
	// function read_products_for_distributor(){


	// }
	function read_product(){

		$sql1 = mysqli_query($link,"SELECT 
                    products.`token`,
                    products.`category_token`,
                    products.`piece_count`,
                    products.`item_code`,
                    products.`name`,
                    products.`total_cost`,
                    products.`gst`,
                    products.`batch_number`,
                    products.`net_weight`,
                    products.`additional_offer`,
                    products.retailer_price,
                    products__category.name AS pro_cat,
                    COALESCE(stock__distributor.stock_in_hand,0) AS stock_in_hand
                FROM
                    `products`
                INNER JOIN products__category ON products__category.token = products.category_token
                INNER JOIN employees__division_mapping ON employees__division_mapping.division_token = products.category_token
                LEFT JOIN stock__distributor ON (stock__distributor.product_token = products.token AND stock__distributor.employee_token = employees__division_mapping.employee_token)
                WHERE
                    employees__division_mapping.delete_status = '1' and products.delete_status =1");
 // employees__division_mapping.employee_token = $distributorToken AND
		// prepare query statement
    $stmt = $this->conn->prepare( $query );

    // bind id of product to be updated
    // $stmt->bindParam(1, $this->id);

    // execute query
    $stmt->execute();

     // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
  
    // set values to object properties
    $this->token = $row['token'];
    $this->category_token = $row['category_token'];
    $this->piece_count = $row['piece_count'];
    $this->item_code = $row['item_code'];
    $this->name = $row['name'];
    $this->total_cost = $row['total_cost'];
    $this->gst = $row['gst'];
    $this->batch_number = $row['batch_number'];
    $this->net_weight = $row['net_weight'];
    $this->retailer_price = $row['retailer_price'];
    $this->pro_cat = $row['pro_cat'];
    $this->stock_in_hand = $row['stock_in_hand'];
    // echo $row['stock_in_hand'];




	}

}





	?>