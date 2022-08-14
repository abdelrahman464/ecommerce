<?php
/*
======================================================
==  Categories  page
==  you can Add | Delete | Edit Categories from here 
======================================================
*/ 


session_start();

$pageTitle  = 'Categories';

if(isset($_SESSION['Username']))
{
    include "init.php"; 
     
    $do =isset($_GET['do'])?$_GET['do']:'Manage' ;

    // start manage page
    if($do == 'Manage')
    {
        $sort='ASC';
        $sort_array =array('ASC','DESC') ;
        if(isset($_GET['sort'])&& in_array($_GET['sort'],$sort_array ))
        {
            $sort = $_GET['sort'];
        }
       $stmt2 = $con->prepare("SELECT * FROM categories WHERE Parent = 0 ORDER by Ordering ".$sort);
       $stmt2->execute();
       $cats = $stmt2->fetchAll();
       
       if(!empty($cats)){
       ?>


<h1 class="text-center ">Manage Members </h1>
<div class="container categories">
    <div class="ordering alert alert-info"><i class="fa fa-sort"></i> Ordering:[
        <a href="categories.php?sort=ASC" class="<?php if($sort=='ASC'){echo 'active';}?>">ASC</a>|
        <a href="categories.php?sort=DESC" class="<?php if($sort=='DESC'){echo 'active';}?>">DESC</a>
        ]
    </div>
    <div class=" table-responsive">
        <table class="main-table text-center table table-bordered">
            <tr>

                <td>Name</td>
                <td>Description</td>
                <td>Ordering</td>
                <td>Visibility</td>
                <td>Allow Comments</td>
                <td>Allow Ads</td>
                <td>Control</td>
            </tr>
            <?php

                        foreach($cats as $cat){
                        ?>
            <tr>
                <td>
                    <h5> <?php echo $cat['Name']?></h5>
                </td>
                <td><?php if($cat['Description']==''){
                    echo '<div style="color:#777;">--This Category Has No Description--</div>';
                    }else{
                        echo $cat['Description'];
                        }
                        ?>
                </td>
                <td><?php echo $cat['Ordering']?></td>
                <?php if($cat['Visibility']==1){
                    ?>
                <td>
                    <div style="font-weight:bold;"><span style="color:red;text-decoration:line-through;"><i
                                class="fa fa-eye"></i> Hidden</span>
                    </div>
                </td>
                <?php
                }else
                {
                    ?>
                <td>
                    <div style="font-weight:bold;"><span style="color:green;"> <i class="fa fa-eye"></i> Visible</span>
                    </div>
                </td>
                <?php
                }
                ?>
                <?php if($cat['Allow_Comments']==1){
                    ?>
                <td>
                    <div style="font-weight:bold;"><span style="color:red;text-decoration:line-through;"><i
                                class="fa fa-close"></i> Comments
                            Disabled</span></div>
                </td>
                <?php
                }else
                {
                    ?>
                <td>
                    <div style="font-weight:bold;"><span style="color:green;"><i class="fa fa-close"></i> Comments
                            Enabled</span></div>
                </td>
                <?php
                }
                ?>
                <?php if($cat['Allow_Ads']==1){
                    ?>
                <td>
                    <div style="font-weight:bold;"> <span style="color:red;text-decoration:line-through;"><i
                                class="fa fa-close"></i> Ads Disabled</span> </div>
                </td>
                <?php
                }else
                {
                    ?>
                <td>
                    <div style="font-weight:bold;"> <span style="color:green;"><i class="fa fa-close">
                            </i> Ads Enabled</span></div>
                </td>
                <?php
                }
                ?>
                <td>

                    <a href="categories.php?do=Edit&catid= <?php echo $cat['ID'] ?>" class="btn btn-success">
                        <i class="fa fa-edit"></i>Edit
                    </a>
                    <a href="categories.php?do=Delete&catid= <?php echo $cat['ID'] ?>" class="btn btn-danger confirm">
                        <i class="fa fa-close"></i>Delete
                    </a>

                </td>
            </tr>
            <?php
            //if there is child category i will echo it 
                $childcats = getRecord("*","categories","ID","WHERE Parent = ".$cat['ID'],"ASC");
                    if(!empty($childcats)){
                        
                        foreach($childcats as $c)
                        {
                            ?>
                            <tr>
                        <td>
                            <h5> <?php echo $c['Name']?>[<?php echo $cat["Name"] ?>]</h5>
                        </td>
                        <td><?php if($c['Description']==''){
                            echo '<div style="color:#777;">--This Category Has No Description--</div>';
                            }else{
                                echo $c['Description'];
                                }
                                ?>
                        </td>
                        <td><?php echo $c['Ordering']?></td>
                        <?php if($c['Visibility']==1){
                            ?>
                        <td>
                            <div style="font-weight:bold;"><span style="color:red;text-decoration:line-through;"><i
                                        class="fa fa-eye"></i> Hidden</span>
                            </div>
                        </td>
                        <?php
                        }else
                        {
                            ?>
                        <td>
                            <div style="font-weight:bold;"><span style="color:green;"> <i class="fa fa-eye"></i> Visible</span>
                            </div>
                        </td>
                        <?php
                        }
                        ?>
                        <?php if($c['Allow_Comments']==1){
                            ?>
                        <td>
                            <div style="font-weight:bold;"><span style="color:red;text-decoration:line-through;"><i
                                        class="fa fa-close"></i> Comments
                                    Disabled</span></div>
                        </td>
                        <?php
                        }else
                        {
                            ?>
                        <td>
                            <div style="font-weight:bold;"><span style="color:green;"><i class="fa fa-close"></i> Comments
                                    Enabled</span></div>
                        </td>
                        <?php
                        }
                        ?>
                        <?php if($c['Allow_Ads']==1){
                            ?>
                        <td>
                            <div style="font-weight:bold;"> <span style="color:red;text-decoration:line-through;"><i
                                        class="fa fa-close"></i> Ads Disabled</span> </div>
                        </td>
                        <?php
                        }else
                        {
                            ?>
                        <td>
                            <div style="font-weight:bold;"> <span style="color:green;"><i class="fa fa-close">
                                    </i> Ads Enabled</span></div>
                        </td>
                        <?php
                        }
                        ?>
                        <td>

                            <a href="categories.php?do=Edit&catid= <?php echo $c['ID'] ?>" class="btn btn-success">
                                <i class="fa fa-edit"></i>Edit
                            </a>
                            <a href="categories.php?do=Delete&catid= <?php echo $c['ID'] ?>" class="btn btn-danger confirm">
                                <i class="fa fa-close"></i>Delete
                            </a>

                        </td>
                    </tr>

        <?php

                        }}
            
            
            ?>


            <?php 
            }

            ?>

        </table>
    </div>


    <a href="categories.php?do=Add " class="botoon btn btn-primary"><i class="fa fa-plus"></i> New Category</a>

    <?php }else{ echo ' <div class="container">';
            echo ' <div class="alert alert-info mt-4"> There\' Is No Categories To Show </div>';
           ?> <a href="categories.php?do=Add " class="botoon btn btn-primary"><i class="fa fa-plus"></i> New Category</a><?php
        }
                    echo '</div> ';?>
</div>

<?php

    }
    elseif($do == 'Add')
    {   
         // add new Category
         ?>
<h1 class="text-center ">Add New Category</h1>
<div class="container">
    <form class="form-horizontal" action="?do=Insert" method="POST">

        <!-- start Name field -->
        <div class="form-group row ">
            <label class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10 col-md-6">
                <div class="input-content">
                    <input required type="text" class="form-control form-control-lg" name="name" autocomplete="off"
                        placeholder="Name Of The Category">
                </div>

            </div>
        </div>
        <!-- end Name field -->
        <!-- start Description field -->
        <div class="form-group row ">
            <label class="col-sm-2 col-form-label">Description</label>
            <div class="col-sm-10 col-md-6">
                <div class="input-content">
                    <input type="text" class="form-control form-control-lg" name="description"
                        placeholder="Describe The Category">
                </div>

            </div>
        </div>
        <!-- end Description field -->
        <!-- start ordering field -->
        <div class="form-group row ">
            <label class="col-sm-2 col-form-label">Ordering</label>
            <div class="col-sm-10 col-md-6 ">
                <div class="input-content">
                    <input type="text" class="form-control form-control-lg" name="ordering" autocomplete="off"
                        placeholder="Number To Arrange The Categoryies">
                </div>
            </div>
        </div>
        <!-- end ordering field -->
        <!-- start category type field -->
        <div class="form-group row ">
            <label class="col-sm-2 col-form-label">Parent ?</label>
            <div class="col-sm-10 col-md-6 ">
                <div class="input-content">
                <select required
                        name="parent"
                        class="form-select form-select-lg"
                        aria-label="Default select example">
                        
                        <option value="0">None</option>
                        <?php
                        $allcats = getRecord("*","categories","ID","WHERE Parent = 0","ASC");
                        foreach($allcats as $cat)
                        {
                            ?>
                             <option value="<?php echo $cat['ID'] ?>"><?php echo $cat['Name'] ?></option>
                             <?php
                        }
                        
                        ?>
                </select>
                </div>
            </div>
        </div>
        <!-- end category type field -->
        <!-- start Visibility field -->
        <div class="form-group row ">
            <label class="col-sm-2 col-form-label">Visible</label>
            <div class="col-sm-10 col-md-6">
                <div class="form-check">
                    <input class="form-check-input" id="vis-yes" type="radio" name="visibility" value="0" checked>
                    <label class="form-check-label" for="vis-yes">Yes</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" id="vis-no" type="radio" name="visibility" value="1">
                    <label class="form-check-label" for="vis-no">No</label>
                </div>
            </div>
        </div>
        <!-- end Visibility field -->
        <!-- start Commenting field -->
        <div class="form-group row ">
            <label class="col-sm-2 col-form-label">Allow Commenting</label>
            <div class="col-sm-10 col-md-6">
                <div class="form-check">
                    <input class="form-check-input" id="cpm-yes" type="radio" name="commenting" value="0" checked>
                    <label class="form-check-label" for="com-yes">Yes</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" id="com-no" type="radio" name="commenting" value="1">
                    <label class="form-check-label" for="com-no">No</label>
                </div>
            </div>
        </div>
        <!-- end Commenting field -->
        <!-- start Ads field -->
        <div class="form-group row ">
            <label class="col-sm-2 col-form-label">Allow Ads</label>
            <div class="col-sm-10 col-md-6">
                <div class="form-check">
                    <input class="form-check-input" id="ads-yes" type="radio" name="ads" value="0" checked>
                    <label class="form-check-label" for="ads-yes">Yes</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" id="ads-no" type="radio" name="ads" value="1">
                    <label class="form-check-label" for="ads-no">No</label>
                </div>
            </div>
        </div>
        <!-- end Ads field -->
        <!-- start submit btn field -->
        <div class="form-group row ">
            <div class="col-sm-offset-6 col-sm-6">
                <input type="submit" class="botoon btn btn-success" value="Add Category">
            </div>
        </div>
        <!-- end submit btn field -->
    </form>


</div>

<?php

    } 
    elseif($do == 'Insert')
    {
        // insert category page
       

        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            echo '<h1 class="text-center">Insert New Category</h1>';
            echo '<div class="container">';
            //get variables from the form
            
                    $name        = $_POST['name'];
                    $desc        = $_POST['description'];
                    $parent      = $_POST['parent'];
                    $order       = $_POST['ordering'];
                    $visible     = $_POST['visibility'];
                    $comment     = $_POST['commenting'];
                    $ads         = $_POST['ads'];
                    
                    
                    // validate the form

                    $fromErrors = array();

                    if(strlen($name)<2 )
                    {
                        $fromErrors[]= ' Name can not be less than <strong> 2 chararcters </strong> </div>';
                    }
                    if(empty($name))
                    {
                        $fromErrors[]= 'Name can not be <strong>Empty</strong> </div>';
                    }
                 
                

                    // loop into error array and echo it
                    foreach( $fromErrors as $error)
                    {
                        echo '<div class="alert alert-danger">'.$error ;
                    }
                

                    // check if there is no errors proceed the update operation

                    if(empty( $fromErrors))
                    {   
                        // check if Category exist in database
                        $check=checkItem("Name","categories",$name);
                        if($check ==1)
                        {
                            $theMsg= '<div class="alert alert-danger">This Category =  <strong>'.$name.'</strong> Already exist' . '</div>';
                            redirectHome($theMsg,'back');
                        }else
                            {   
                                    //Insert category info into database 

                                $stmt = $con->prepare(" INSERT INTO
                                categories(Name,Description,Parent,Ordering,Visibility,Allow_Comments,Allow_Ads)
                            VALUES  
                                (:zname,:zdesc,:zparent,:zorder,:zvisible,:zcomment,:zads)");
                                            $stmt->execute(array(
                                            'zname'      =>$name,
                                            'zdesc'      =>$desc,
                                            'zparent'    =>$parent,
                                            'zorder'     =>$order,
                                            'zvisible'   =>$visible,
                                            'zcomment'   =>$comment,
                                            'zads'       =>$ads
                                            


                            ));
                            // echo successful msg and redirect to previos page

                            $theMsg= '<div class="alert alert-success "> <strong>'.$stmt->rowcount().'</strong> Record Inserted' . '</div>';
                            redirectHome($theMsg,'back');
                        }
                        }
                }
                else
                {
                    echo '<div class="container">';
                    $theMsg = '<div class= "alert alert-danger mt-5">  Sorry You Can Not Browes This Page Directly </div>';
                    redirectHome($theMsg,'back');
                    echo '</div>';
                }

        echo '</div>';
        
    }
    elseif($do == 'Edit')
    {
        // check if get requestis catid is numeric & get the intger value of it
        $catid= isset($_GET['catid']) && is_numeric($_GET['catid'])? intval($_GET['catid']): 0 ;
        // select all data depent on this iD
        $stmt = $con->prepare("SELECT * FROM categories WHERE ID = ?  ");
        // execute query
        $stmt->execute(array($catid));
        // fetch the data from the database
        $cat = $stmt->fetch();  
        // row count 
        // if there is this iD or no
        $count = $stmt->rowCount();
        // if there is id show the from 
        if($stmt->rowCount() > 0)
        {
            
        // Edite page
        ?>
<h1 class="text-center ">Edit category</h1>
<div class="container">
    <form class="form-horizontal" action="?do=Update" method="POST">

        <!-- start Name field -->
        <div class="form-group row ">
            <label class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10 col-md-6">
                <div class="input-content">
                    <input required type="text" class="form-control form-control-lg" name="name"
                        placeholder="Name Of The Category" value="<?php echo $cat['Name']?>">
                </div>

            </div>
        </div>
        <!-- end Name field -->
        <!-- start Description field -->
        <div class="form-group row ">
            <label class="col-sm-2 col-form-label">Description</label>
            <div class="col-sm-10 col-md-6">
                <div class="input-content">
                    <input type="text" class="form-control form-control-lg" name="description"
                        placeholder="Describe The Category" value="<?php echo $cat['Description']?>">
                </div>

            </div>
        </div>
        <!-- end Description field -->
        <!-- start category type field -->
        <div class="form-group row ">
            <label class="col-sm-2 col-form-label">Parent ?</label>
            <div class="col-sm-10 col-md-6 ">
                <div class="input-content">
                <select required
                        name="parent"
                        class="form-select form-select-lg"
                        aria-label="Default select example">
                        
                        <option value="0">None</option>
                        <?php
                        $allcats = getRecord("*","categories","ID","WHERE Parent = 0","ASC");
                        foreach($allcats as $c)
                        {
                            ?>
                             <option <?php if($cat['Parent'] == $c['ID'] ){echo 'selected';} ?>  value="<?php echo $c['ID'] ?>"><?php echo $c['Name'] ?></option>
                             <?php
                        }
                        
                        ?>
                </select>
                </div>
            </div>
        </div>
        

        <!-- end category type field -->
        <!-- start ordering field -->
        <div class="form-group row ">
            <label class="col-sm-2 col-form-label">Ordering</label>
            <div class="col-sm-10 col-md-6 ">
                <div class="input-content">
                    <input type="text" class="form-control form-control-lg" name="ordering" autocomplete="off"
                        placeholder="Number To Arrange The Categoryies" value="<?php echo $cat['Ordering']?>">
                </div>
            </div>
        </div>
        <!-- end ordering field -->
        <!-- start Visibility field -->
        <div class="form-group row ">
            <label class="col-sm-2 col-form-label">Visible</label>
            <!-- hidden input to let us use the id of the category witch come from $_GET 
                WE Use this id in Insert page -->
            <input type="hidden" name="catid" value="<?php echo $catid;?>">
            <div class="col-sm-10 col-md-6">
                <div class="form-check">
                    <input class="form-check-input" id="vis-yes" type="radio" name="visibility" value="0"
                        <?php if($cat['Visibility']==0){echo 'checked';} ?>>
                    <label class="form-check-label" for="vis-yes">Yes</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" id="vis-no" type="radio" name="visibility" value="1"
                        <?php if($cat['Visibility']==1){echo 'checked';} ?>>
                    <label class="form-check-label" for="vis-no">No</label>
                </div>
            </div>
        </div>
        <!-- end Visibility field -->
        <!-- start Commenting field -->
        <div class="form-group row ">
            <label class="col-sm-2 col-form-label">Allow Commenting</label>
            <div class="col-sm-10 col-md-6">
                <div class="form-check">
                    <input class="form-check-input" id="cpm-yes" type="radio" name="commenting" value="0"
                        <?php if($cat['Allow_Comments']==0){echo 'checked';} ?>>
                    <label class="form-check-label" for="com-yes">Yes</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" id="com-no" type="radio" name="commenting" value="1"
                        <?php if($cat['Allow_Comments']==1){echo 'checked';} ?>>
                    <label class="form-check-label" for="com-no">No</label>
                </div>
            </div>
        </div>
        <!-- end Commenting field -->
        <!-- start Ads field -->
        <div class="form-group row ">
            <label class="col-sm-2 col-form-label">Allow Ads</label>
            <div class="col-sm-10 col-md-6">
                <div class="form-check">
                    <input class="form-check-input" id="ads-yes" type="radio" name="ads" value="0"
                        <?php if($cat['Allow_Ads']==0){echo 'checked';} ?>>
                    <label class="form-check-label" for="ads-yes">Yes</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" id="ads-no" type="radio" name="ads" value="1"
                        <?php if($cat['Allow_Ads']==1){echo 'checked';} ?>>
                    <label class="form-check-label" for="ads-no">No</label>
                </div>
            </div>
        </div>
        <!-- end Ads field -->
        <!-- start submit btn field -->
        <div class="form-group row ">
            <div class="col-sm-offset-6 col-sm-6">
                <input type="submit" class="botoon btn btn-success btn-lg " value="Save">
            </div>
        </div>
        <!-- end submit btn field -->
    </form>

</div>
<?php

       }
       //if there is no such iD show error msg
       else
       {
        echo '<div class="container">';
        $theMsg= '<div class="alert alert-danger mt-5"> there is no such iD </div>';
        redirectHome($theMsg);
        echo '</div>';
       }
    }
    elseif($do == 'Update')
    {   
        // update page
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            echo '<h1 class="text-center">Update Category</h1>';
            echo '<div class="container">';
            //get variables from the form
            $id          = $_POST['catid'];
            $name        = $_POST['name'];
            $desc        = $_POST['description'];
            $parent      = $_POST['parent'];
            $order       = $_POST['ordering'];
            $visible     = $_POST['visibility'];
            $comment     = $_POST['commenting'];
            $ads         = $_POST['ads'];

            // validate the form

            $fromErrors = array();

            if(strlen($name) <=2 )
            {
                $fromErrors[]= ' name can not be less than <strong> 2 chararcters </strong> </div>';
            }
            if(empty($name))
            {
                $fromErrors[]= ' name can not be <strong>Empty</strong> </div>';
            }
            

            // loop into error array and echo it
            foreach( $fromErrors as $error)
            {
                echo '<div class="alert alert-danger">'.$error ;
            }
           

            // check if there is no errors proceed the update operation

            if(empty( $fromErrors))
            {

                $stmt2=$con->prepare("SELECT * FROM categories WHERE  ID != ? AND Name = ?");
                $stmt2->execute(array($name,$id));
                $count =$stmt2->rowCount();

                if($count==1)
                {
                    $theMsg= '<div class="alert alert-danger">this Name = <strong>'.$name.'</strong> Already exist' . '</div>';
                    redirectHome($theMsg,'back');
                }else{

                    //update the database with this info

              
                $stmt = $con->prepare(' UPDATE 
                                                categories
                                         SET 
                                                 Name           =? ,
                                                 Description    =? ,
                                                 parent        =? ,
                                                 Ordering       =? ,
                                                 Visibility     =? ,
                                                 Allow_Comments =? ,
                                                 Allow_Ads      =?
                                         WHERE 
                                                ID=?');
                $stmt->execute(array($name,$desc,$parent,$order,$visible,$comment,$ads,$id));

                // echo successful msg and redirect to previos page

                $theMsg = '<div class="alert alert-success"> <strong>'.$stmt->rowcount().'</strong> Record Updated' . '</div>';
                redirectHome($theMsg,'back');
                
                }





                
            }
        }
        else
        {
              echo '<div class="container">';
                    $theMsg =' <div class="alert alert-danger mt-5">Sorry You Can Not Browes This Page Directly </div>';
                    redirectHome($theMsg);
              echo '</div>';

        }

        echo '</div>';
    }
    elseif($do == 'Delete')
    {
        // Delete memeber page
        echo '<h1 class="text-center">Delete Member</h1>';
        echo '<div class="container">';
         // check if get requestis numeric & get the intger value of it
         $catid = isset($_GET['catid']) && is_numeric($_GET['catid'])? intval($_GET['catid']): 0 ;
         // select all data depent on this iD
         $check=checkItem("ID","categories", $catid);
         // if there is id show the from 
         if($check > 0)
         {  
            $stmt =$con->prepare('DELETE FROM categories WHERE ID = :zid');
            $stmt->bindParam(':zid',$catid );
            $stmt->execute();
            $theMsg=  '<div class="alert alert-success"> <strong>'.$stmt->rowcount().'</strong> Record Deleted' . '</div>';
            redirectHome($theMsg,'back');
         }else{
            $theMsg= '<p class="alert alert-danger"> this iD is not exist</p>';
            redirectHome($theMsg);
         }
         echo '</div>';
    }
    
  
    include $tpl."footer.php";
}else
{
  header('location: index.php');
  exit();
}