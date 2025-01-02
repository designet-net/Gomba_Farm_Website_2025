<?php 
    include('header.php');
    include('conn.php');
?>  
<section style="background-color:#ffffff; " 
    id="section5" class="menu_page">
    <div class="container">
        <div class="">
                <h2 class="section_title">Update News</h2>
                    <p>
                <div class="fourcolumn-news">
                <p><a href="add_news.php"><button>Add News</button></a></p>
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
                            $select = "SELECT * FROM news_updates limit 4";
                            $result = mysqli_query($connection,$select);
                            while($row = mysqli_fetch_array($result)):
                        ?>
                            <tr>
                                 <input type="hidden" name="id"
                                    value="<?php echo $row['id']; ?>">
                                <td><?php echo $row['news_date'];?></td>
                                <td><?php echo $row['title'];?></td>
                                <td><?php echo $row['content'];?></td>
                                <td class ="paragraphs"><?php echo $row['class_name'];?>
									<a href="edit_news.php?news_ID=<?php  echo $row['news_ID'] ;?>"
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