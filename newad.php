<?php
session_start();
$pageTitle='Create New Item';
include "init.php";

if(isset($_SESSION['user']))
{
    if($_SERVER['REQUEST_METHOD']=='POST')
    {

        $formErrors = array();

        //uploded files
        $imageName     = $_FILES['image']['name'] ;
        $imagePath     = $_FILES['image']['full_path'] ;
        $imageType     = $_FILES['image']['type'] ;
        $imageTmp_Name = $_FILES['image']['tmp_name'] ;
        $imageEror     = $_FILES['image']['error'] ;
        $imageSize     = $_FILES['image']['size'] ;
        // list of allowed file type of upload
        $imageAllowedExtentions = array("jpeg","jpg","gif","png");
        //get image extention
        $exploded=explode('.', $imageName );
        $endofarray=end($exploded );
        $imageExtentions = strtolower($endofarray);

        $name        = $_POST['name'];
        $desc        = $_POST['description'];
        $price       = filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_FLOAT,["flags"=> FILTER_FLAG_ALLOW_THOUSAND |FILTER_FLAG_ALLOW_FRACTION]);
        $country     = $_POST['country_made'];
        $status      = filter_var($_POST['status'],FILTER_SANITIZE_NUMBER_INT);   
        $category    = $_POST['category']; 
        $tags        = $_POST['tags']; 
        
        
        if(strlen($name)<4)
        {
            $formErrors[] = "Item Title Must be Larger than 4 chars";
        }
        if(strlen($desc)<10)
        {
            $formErrors[] = "Item description Must be Larger than 10 chars";
        }
        if(strlen($country)<2)
        {
            $formErrors[] = "country Must be Larger than 2 chars";
        }
        if(empty($price))
        {
            $formErrors[] = "item price Must be Not Empty";
        }
        if(empty($status))
        {
            $formErrors[] = "item status Must be Not Empty";
        }
        if(empty($category))
        {
            $formErrors[] = "item category Must be Not Empty";
        }
        if(!empty($imageName)){
            if(!in_array($imageExtentions,$imageAllowedExtentions)){
                $fromErrors[]= 'This Extention is Not  <strong>Allowed</strong> </div>';
            }
            if($imageSize > 4194304 ){ 
                $fromErrors[]= 'Avatar Can\'t be More Than <strong>4MB</strong> </div>';
            }
        }

        // check if there is no errors proceed the update operation
        if(empty( $formErrors))
        {          
            if(!empty($imageName)){
                $image = rand(0,10000000).$user.'_'.$imageName;
                move_uploaded_file($imageTmp_Name,"Admin\uploads\images\items\\".$image);
            }else
            {
                $image = 'defalt.jpg';
                move_uploaded_file($imageTmp_Name,"Admin\uploads\images\items\\".$image);
            }
            //Insert user info into database  this info
                    $stmt = $con->prepare(" INSERT INTO
                    items(Name, Description, Price, Country_Made,Image, Status, Add_Date,Cat_ID,Member_ID,Tags)
                                            VALUES  
                    (:zname, :zdesc, :zprice, :zcountry_made,:zimage, :zstatus, now(),:zcatid,:zmemberid,:ztag )");
                                $stmt->execute(array(
                                'zname'           => $name,
                                'zdesc'           => $desc,
                                'zprice'          => $price,
                                'zcountry_made'   => $country,
                                'zimage'          => $image,
                                'zstatus'         => $status, 
                                'zcatid'          => $category, 
                                'ztag'            => $tags, 
                                'zmemberid'       => $_SESSION['uid'] 
                ));
                // echo successful msg and redirect to previos page 
                 if($stmt){
                    echo '<div class="container mt-3"><div class="alert alert-success"> <strong>Item</strong> Added </div></div>';
               
                                
                }
               
                
            
        }  



    }

?>


<h1 class="text-center">Create New Ad</h1>

<div class="mt-4">
    <div class="container ">
    <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-tag"></i>
                       Create New Ad
                    </div>
                    <div class="card-body ">
                        
                        <div class="row">

                            <div class="col-md-8">
                                <form class="form-horizontal main-fromo" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                                                        
                                    <!-- start Name field -->
                                    <div class="form-group row ">
                                        <label class="col-sm-2 col-form-label">Name</label>
                                        <div class="col-sm-10 col-md-8">
                                            <div class="input-content">
                                                <input  pattern=".{4,}"
                                                        title="item title Must be larger than 4 Chars"
                                                        required 
                                                        type="text"
                                                        class="form-control form-control-lg live-name" 
                                                        name="name"
                                                        placeholder="Name Of The Item"
                                                        data-clas>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end Name field -->
                                    <!-- start Description field -->
                                    <div class="form-group row field-row">
                                        <label class="col-sm-2 col-form-label">Description</label>
                                        <div class="col-sm-10 col-md-8">
                                            <div class="input-content">
                                                <input  required
                                                        type="text"
                                                        class="form-control form-control-lg live-desc" 
                                                        name="description"
                                                        placeholder="Describe The Item">
                                            </div>

                                        </div>
                                    </div>
                                    <!-- end Description field -->
                                    <!-- start Price field -->
                                    <div class="form-group row ">
                                        <label class="col-sm-2 col-form-label">Price</label>
                                        <div class="col-sm-10 col-md-8">
                                            <div class="input-content">
                                                <input  required
                                                        type="text"
                                                        class="form-control form-control-lg live-price" 
                                                        name="price"
                                                        placeholder="Price  Of The Item">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end Price field -->
                                    <!-- start Price field -->
                                    <div class="form-group row ">
                                        <label class="col-sm-2 col-form-label">Item Image</label>
                                        <div class="col-sm-10 col-md-8">
                                            <div class="input-content">
                                                <input  
                                                        type="file"
                                                        class="form-control form-control-lg live-image" 
                                                        name="image"
                                                        >
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end Price field -->
                                    <!-- start Country_Made field -->
                                    <div class="form-group row ">
                                        <label class="col-sm-2 col-form-label">Country</label>
                                        <div class="col-sm-10 col-md-8">
                                            <div class="input-content">
                                                <input  required
                                                        type="text"
                                                        class="form-control form-control-lg" 
                                                        name="country_made"
                                                        placeholder="Country Of Made ">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end Country_Made field -->
                                    <!-- start Status field -->
                                    <div class="form-group row ">
                                        <label class="col-sm-2 col-form-label">Status</label>
                                        <div class="col-sm-10 col-md-8">
                                            <div class="input-content">
                                                <select required
                                                        name="status" class="form-select form-select-lg" aria-label="Default select example">
                                                    <option value="">...</option>
                                                    <option value="1">New</option>
                                                    <option value="2">Like New</option>
                                                    <option value="3">Used</option>
                                                    <option value="4">Old</option>
                                                    <option value="5">Very Old</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end Status field -->
                                    
                                    <!-- start Categories field -->
                                    <div class="form-group row ">
                                        <label class="col-sm-2 col-form-label">Category</label>
                                        <div class="col-sm-10 col-md-8">
                                            <div class="input-content">
                                                <select required
                                                        name="category"
                                                        class="form-select form-select-lg"
                                                         aria-label="Default select example">
                                                    <option value="">...</option>
                                                    <?php
                                                        $categories = getRecord("*","categories","ID","WHERE Visibility = 0 AND Parent = 0","ASC");
                                                       

                                                        foreach($categories as $category){
                                                            ?>
                                                        
                                                        <option value="<?php echo $category['ID']; ?>"> <?php echo $category['Name'];?></option>
                                                        <?php
                                                        $childcategories =getRecord("*","categories","ID","WHERE Visibility = 0 AND Parent = ".$category['ID'],"ASC");
                                                            foreach($childcategories as $childcat){
                                                                ?>
                                                                    <option value="<?php echo $childcat['ID']; ?>"> ---<?php echo $childcat['Name'];?> [ <?php echo $category['Name'];?> ] </option>
                                                                <?php
                                                            }
                                                        ?>
                                                        <?php
                                                          }
                                                        
                                                    
                                                    ?>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end Categories field -->
                                    <!-- start Tags field -->
                                    <div class="form-group row ">
                                        <label class="col-sm-2 col-form-label">Country</label>
                                        <div class="col-sm-10 col-md-8">
                                            <div class="input-content">
                                                <input  
                                                        type="text"
                                                        class="form-control form-control-lg" 
                                                        name="tags"
                                                        placeholder="Separet Tags With comma (,) ">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end Tags field -->
                                    <!-- start submit btn field -->
                                    <div class="form-group row ">
                                        <div class="col-sm-offset-2 col-sm-8">
                                            <input type="submit" class="botoon btn btn-success " value="Add Ad">
                                        </div>
                                    </div>
                                    <!-- end submit btn field -->
                                </form>
                            
                                
                            </div>
                            <!-- the live item-->
                            <div class="col-md-4">
                                <div class="card col-sm-6 col-md-3 m-3 live-preview" style="width: 18rem;">
                                <img class="card-img-top imag-live" src="Admin\uploads\images\items\defalt.jpg" alt="Card image cap">
                                <div class="card-body itemCard">
                                    <h5 class="card-title">Tittle</h5>
                                    <span class="Price-tag"><span class="price"></span> EGP</span>
                                    <p class="card-text">Description</p>
                                
                                </div>
                            </div>
                                </div>
                        </div>

                        <!-- start looping $formErrors-->
                        <?php
                                if(!empty($formErrors))
                                {
                                    foreach($formErrors as $error)
                                    {
                                        echo '<div class = "alert alert-danger" > '.$error . '</div>';
                                    }
                                }

                        ?>        

                        <!-- end looping $formErrors-->



                    </div>
                 </div>
            </div>  
    </div>


</div>




<?php
}else
{
    header("Location: Login.php");
    exit();
}


include $tpl.'footer.php'; 