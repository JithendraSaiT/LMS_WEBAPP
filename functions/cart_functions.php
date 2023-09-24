<?php

	function total_price($cart){
		$price = 0.0;
		if(is_array($cart)){
			foreach($cart as $isbn => $qty){
				$bookprice = getbookprice($isbn);
				if(is_numeric($bookprice) && is_numeric($qty)){
					$price += $bookprice * $qty;
				}
			}
		}
		return $price;
	}

	
	function total_items($cart){
		$items = 0;
		if(is_array($cart)){
			foreach($cart as $isbn => $qty){
				$qty = intval($qty); 
				if(is_numeric($qty)){
					$items += $qty;
				}
			}
		}
		return $items;
	}
	
?>