<?php
sleep(1);
include('config.php');
if(isset($_POST['lastid'])){
    $lastid=$_POST['lastid'];
    $query=mysqli_query($conn,"select * from a_products where id > '$lastid' order by id asc limit 5");

    if(mysqli_num_rows($query) > 0){
        while($row = mysqli_fetch_array($query)){
            ?>
            <div class="col-md-4 mt-3">
                <div class="border p-2">
                    <h6><?= $row['name']; ?></h6>
                </div>
            </div>
            <?php
            $lastid=$row['id'];
        }
        ?>
        <div id="remove">
            <div id="remove_row" class="row">
                <div class="col-lg-12  text-center mb-2">
                    <button type="button" name="loadmore" id="loadmore" data-id="<?php echo $lastid; ?>" class="btn btn-primary">See More</button>
                </div>
            </div>
        </div>
        <?php
    }
}
?>
