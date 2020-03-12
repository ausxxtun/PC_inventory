<?php

//get all products
function getAllProducts($db)
{
$sql = 'Select p.brand, p.price, c.brand as category from products p ';
$sql .='Inner Join categories c on p.category_id = c.id';
$stmt = $db->prepare ($sql);
$stmt ->execute();
return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//get product by id

function getProducts($db, $productBrand)
{
$sql = 'Select p.brand, p.description, p.price, c.brand, c.description from products p ';
$sql .= 'Inner Join categories c on p.category_id = c.id ';
$sql .= ' Where c.brand = :brand'; 
$stmt = $db->prepare ($sql);
$id =  $productBrand;
$stmt->bindParam(':brand', $productBrand, PDO::PARAM_STR);
$stmt->execute();
return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function createProduct($db, $form_data) {
    $sql = 'Insert into products (brand, description, price, category_id, created) ';
    $sql .= 'values (:brand, :description, :price, :category_id, :created)';
    $stmt = $db->prepare ($sql);
    $stmt->bindParam(':brand', $form_data['brand']);
    $stmt->bindParam(':description', $form_data['description']);
    $stmt->bindParam(':price', floatval($form_data['price']));
    $stmt->bindParam(':category_id', intval($form_data['category_id']));
    $stmt->bindParam(':created', $form_data['created']);
    $stmt->execute();
    return $db->lastInsertID();//insert last number.. continue
    }

    //delete product by id
function deleteProduct($db,$productId) {
    $sql = ' Delete from products where id = :id';
    $stmt = $db->prepare($sql);
    $id = (int)$productId;
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    }
    
    //update product by id
    function updateProduct($db,$form_dat,$productId,$date) {
        $sql = 'UPDATE products p INNER JOIN categories c ON c.id = p.category_id SET p.brand = :pBrand , p.description = :description , p.price = :price , p.created = CURRENT_TIMESTAMP, p.modified = :modified ';
        $sql .=' WHERE c.brand = :brand';
    
        $stmt = $db->prepare ($sql);
        $id = $productId;
        $mod = $date;
    
        $stmt->bindParam(':brand', $id, PDO::PARAM_STR);
        $stmt->bindParam(':pBrand', $form_dat['pBrand']);
        $stmt->bindParam(':description', $form_dat['description']);
        $stmt->bindParam(':price', floatval($form_dat['price']));
        $stmt->bindParam(':modified', $mod , PDO::PARAM_STR);
        $stmt->execute();
      
    }    