<?php 
    include('header.php');
    include('conn.php');
?>  
<section style="background-color:#ffffff; " 
    id="section5" class="menu_page">
    <div class="container">
        <div class="">
                <h2 class="section_title">Testimonies</h2>
                    <p>
                <div class="fourcolumn-news">
                <p><a href="add_testimonies.php"><button>Add Testimonies</button></a></p>
                <table border="1">
                    <thead>
                        <tr>
                            <th style="text-transform:uppercase;width:20%">Date</th>
                            <th style="text-transform:uppercase;width:30%">Title</th>
                            <th style="text-transform:uppercase;width:45%">Content</th>
                            <th style="text-transform:uppercase;width:5%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $select = "SELECT * FROM testimonies";
                            $result = mysqli_query($connection,$select);
                            while($row = mysqli_fetch_array($result)):
                        ?>
                            <tr>
                                 <input type="hidden" name="id"
                                    value="<?php echo $row['id']; ?>">
                                <td><?php echo $row['date_test'];?></td>
                                <td><?php echo $row['title'];?></td>
                                <td><?php echo $row['content'];?></td>
                                <td class ="paragraphs">
									<a href="edit_test.php?test_ID=<?php  echo $row['id'] ;?>"
									 >Edit</a>
								</td>
                            </tr>
                        <?php  endwhile; ?>                  
                    </tbody>           
                </table>
                <div class="clear"></div>
                </p>
            </div><!-- .end section class -->  
        <div class="clear"></div>                 
    </div><!-- container -->
</section>
<?php include('footer.php');?>  