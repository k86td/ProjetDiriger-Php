<?php
    $user_id = 1;
    $query = "SELECT * FROM products";
    $result = mysqli_query($connection, $query);
    
    while($row = mysqli_fetch_array($result)){
        $product_id = $row['id'];
        $name = $row['name'];
        $description = $row['description'];
        // Star rating
        $query = "SELECT * FROM product_rating WHERE product_id = " . $product_id . " and user_id = " . $user_id;
        $productResult = mysqli_query($connection, $query);
        $getRating = mysqli_fetch_array($productResult);
        $rating = $getRating['rating'];
        // Rating
        $query = "SELECT ROUND(AVG(rating), 1) as numRating FROM product_rating WHERE product_id=".$product_id;
        $avgresult = mysqli_query($connection, $query);
        $fetchAverage = mysqli_fetch_array($avgresult);
        $numRating = $fetchAverage['numRating'];
        if($numRating <= 0){
            $numRating = "Not ratings given.";
        }
?>
<div class="card mb-3">
    <div class="card-body">
        <h2 class="card-title"><?php echo $name; ?></h2>
        <p class="card-text">
            <?php echo $description; ?>
        </p>
        <!-- 5 Star Rating -->
        <select name="star_rating_option" class="rating" id='star_rating_<?php echo $product_id; ?>'
            data-id='rating_<?php echo $product_id; ?>'>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
        Rating : <span id='numeric_rating_<?php echo $product_id; ?>'><?php echo $numRating; ?></span>                
    </div>
</div>
<?php } ?>