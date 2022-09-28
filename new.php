<div class="box-body">
                <form role="form" action="" method="post">

                    <?php
                    
                    if(isset($_POST['btnedit'])){
                        $select=$pdo->prepare("select * from onek_category where catid=".$_POST['btnedit']);
                        $select->execute();
                        if($select){
                            $row=$select->fetch(PDO::FETCH_OBJ);
                            echo'
                            <div class="col-md-4">
                            <div class="form-group">
                                <label>Category</label>
                                <input type="hidden" class="form-control"  placeholder="Enter the category name" name="txtid" value="'.$row->catid.'">
                                <input type="text" class="form-control"  placeholder="Enter the category name" name="txtcategory" value="'.$row->category.'">

                            </div>
                                <button type="submit" class="btn btn-success" name="btnupdate">Update</button>
                            </div>
                            ';
                        }
                    }else{
                        echo'
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Category</label>
                                <input type="text" class="form-control"  placeholder="Enter the category name" name="txtcategory">

                            </div>
                                <button type="submit" class="btn btn-success" name="btnsave">Save</button>
                                
                         </div>
                        ';
                    }
                    
                    ?>
                  
                  <div class="col-md-8">
                   
                    <table id="onekTable" class="table table-striped">
                      <thead>
                        <tr>
                          <th hidden>#</th>  
                          <th>Category</th>
                          <th>Edit</th>
                          <th>Delete</th>
                        </tr>
                      </thead>
                      <tbody>
                              
                          
                                <?php
                                 
                                $select=$pdo->prepare("select * from onek_category order by catid desc");
                                $select->execute();
                                 while($row = $select->fetch(PDO::FETCH_OBJ)){

                                    echo'<tr>
                                    
                                        <td hidden>'.$row->catid.'</td>
                                        <td>'.$row->category.'</td>
                                        <td>
                                        <button type="submit" value="'.$row->catid.'" class="btn btn-success" name="btnedit">Edit</button></td>
                                        <td>
                                        <button type="submit" class="btn btn-danger" name="btndelete" value="'.$row->catid.'">Delete</button>
                                        </td>
                                    
                                    </tr>';

                                 } 
                                 
                                ?>
                            

                      </tbody>
                    </table>
                    
                  </div>
                </form>   
              </div>