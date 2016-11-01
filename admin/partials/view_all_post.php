

<div class="col-xs-12">
                         <table class="table">
    <thead class="">
      <tr>
        <th>Id</th>
        <th>Title</th>
        
        <th>author</th>
        <th>published</th>
        <th>status</th>
        <th>Views</th>
        <th>Comments</th>
        <th>Category</th>
        <th>tags</th>

      </tr>
    </thead>
    <tbody>
      
      <?php foreach ($allPosts as $item): ?>
      	<tr> 
        <td><?php echo $item['post_id'];?></td>
        <td><?php echo $item['title'];?></td>

        <td><?php echo $item['author'];?></td>
        <td><?php echo $item['published'];?></td>
        <td><?php echo $item['status'];?></td>
        <td><?php echo $item['view_count'];?></td>
        <td><?php echo $item['comments_count'];?></td>
        <td><?php echo $item['cat_id'];?></td>
        <td><?php echo $item['tags'];?></td>
 
        <td><a class ="btn btn-warning" href="post.php?edit=<?php echo $item['post_id'];?>">Edit</a></td>
         <td><a class ="btn btn-danger" href="post.php?delete=<?php echo $item['post_id'];?>">Delete</a></td>
      </tr>

      	
      <?php endforeach ?>
       
     
    </tbody>
  </table>
 </div>



