<?php $con = mysqli_connect("localhost","root","","product_filter"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Funda of Web IT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-3">
                <div class="card-header">
                    <h4>How to Filter or Find or Search data using Multiple Checkbox in php</h4>
                </div>
            </div>
        </div>

        <!-- Brand List  -->
        <div class="col-md-3">

            <form action="" method="post">
                <div class="input-group mb-3 mt-5 col-6 mx-auto">
                    <input type="text" class="form-control" name="key" placeholder="search here...">
                    <button class="btn btn-secondary" name="submit" type="submit">Search</button>
                </div>
            </form>
            <form action="" method="GET">
                <div class="card shadow mt-3">
                    <div class="card-header">
                        <h5>Filter
                            <button type="submit" class="btn btn-primary btn-sm float-end">Search</button>
                        </h5>
                    </div>
                    <div class="card-body">
                        <h6>Brand List</h6>
                        <hr>
                        <?php


                        $brand_query = "SELECT * FROM a_brands";
                        $brand_query_run  = mysqli_query($con, $brand_query);



                        if(mysqli_num_rows($brand_query_run) > 0)
                        {
                            foreach($brand_query_run as $brandlist)
                            {
                                $checked = [];
                                if(isset($_GET['brands']))
                                {
                                    $checked = $_GET['brands'];
                                }
                                ?>
                                <div>
                                    <input type="checkbox" name="brands[]" value="<?= $brandlist['id']; ?>"
                                        <?php if(in_array($brandlist['id'], $checked)){ echo "checked"; } ?>
                                    />
                                    <?= $brandlist['name']; ?>
                                </div>
                                <?php
                            }
                        }
                        else
                        {
                            echo "No Brands Found";
                        }
                        ?>
                    </div>
                </div>
            </form>
        </div>

        <!-- Brand Items - Products -->
        <div class="col-md-9 mt-3">
            <div class="card ">
                <div id="loadtable" class="card-body row">



                    <?php
                    if(isset($_GET['brands']))
                    {
                        $branchecked = [];
                        $branchecked = $_GET['brands'];
                        foreach($branchecked as $rowbrand)
                        {
                            // echo $rowbrand;
                            $products = "SELECT * FROM a_products WHERE brand_id IN ($rowbrand)";
                            $products_run = mysqli_query($con, $products);
                            if(mysqli_num_rows($products_run) > 0)
                            {
                                foreach($products_run as $proditems) :
                                    ?>
                                    <div class="col-md-4 mt-3">
                                        <div class="border p-2">
                                            <h6><?= $proditems['name']; ?></h6>
                                        </div>
                                    </div>
                                <?php
                                endforeach;
                            }
                        }
                    }
                    else
                    {
                        if(isset($_POST['submit']))
                        {

                            $search = $_POST['key'];
                            $sql = "SELECT * FROM a_products WHERE name LIKE '%$search%'";
                            $result = mysqli_query($con,$sql);

                            foreach($result as $r):
                            ?>


                                <div class="col-md-4 mt-3">
                                    <div class="border p-2">
                                        <h6><?= $r['name']; ?></h6>
                                    </div>
                                </div>


                        <?php endforeach;

                        }else
                            {
                                $lastid='';

                                $query=mysqli_query($con,"select * from a_products order by id asc limit 5");
                                while ($row = mysqli_fetch_assoc($query)){
                                    ?>
                                    <div class="col-md-4 mt-3">
                                        <div class="border p-2">
                                            <h6><?= $row['name']; ?></h6>
                                        </div>
                                    </div>
                    <?php
                                    $lastid=$row['id'];
                            }
                        }
                    }
                    ?>
                    <div id="remove">
                        <div class="row">
                            <div class="col-lg-12 text-center mt-2 mb-2">
                                <button type="button" name="loadmore" id="loadmore" data-id="<?php echo $lastid; ?>" class="btn btn-primary">See More</button>
                            </div>
                        </div>
                    </div>
7
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $(document).on('click', '#loadmore', function(){
            var lastid = $(this).data('id');
            $('#loadmore').html('Loading...');
            $.ajax({
                url:"load_data.php",
                method:"POST",
                data:{
                    lastid:lastid,
                },
                dataType:"text",
                success:function(data)
                {
                    if(data != '')
                    {
                        $('#remove').remove();
                        $('#loadtable').append(data);
                    }
                    else
                    {
                        $('#loadmore').html('No more data to show');
                    }
                }
            });
        });
    });
</script>
</body>
</html>