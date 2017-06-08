<table class="table">
     <tr>
         <th>id</th>
         <th>姓名</th>
         <th>年龄</th>
     </tr>
     <?php foreach($users as $user):?>
     <tr>
         <td><?=$user->id?></td>
         <td><?=$user->name?></td>
         <td><?=$user->age?></td>
     </tr>
    <?php endforeach;?>
</table>