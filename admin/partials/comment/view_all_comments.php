<?php

$allComments = getComments();













?>




<div class="col-xs-12">
                         <table class="table">
    <thead class="">
      <tr>
        <th>Id</th>
        <th>Comment Author</th>
        
        <th>Email</th>
        <th>Comment</th>
        <th>Status</th>
        <th>Post ID</th>
        <th>Commment Date</th>
       

      </tr>
    </thead>
    <tbody>
      
      <?php foreach ($allComments as $item): ?>
      	<tr> 
        <td><?php echo $item['comment_id'];?></td>
        <td><?php echo $item['comment_author'];?></td>

        <td><?php echo $item['comment_author_email'];?></td>
        <td><?php echo $item['comment'];?></td>
        <td><?php echo $item['comment_status'];?></td>
        <td><?php echo $item['comment_post_id'];?></td>
        <td><?php echo $item['comment_date'];?></td>
        
        
        
 
        <td><a class ="btn btn-success" href="comment.php?approve=<?php echo $item['comment_id'];?>">Approve</a></td>
        <td><a class ="btn btn-warning" href="comment.php?unapprove=<?php echo $item['comment_id'];?>">Block</a></td>
         <td><a class ="btn btn-danger" href="comment.php?delete=<?php echo $item['comment_id'];?>">Delete</a></td>
      </tr>

      	
      <?php endforeach ?>
       
     
    </tbody>
  </table>
 </div>