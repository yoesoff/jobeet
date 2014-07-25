<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $book->getId() ?></td>
    </tr>
    <tr>
      <th>Title:</th>
      <td><?php echo $book->getTitle() ?></td>
    </tr>
    <tr>
      <th>Price:</th>
      <td><?php echo $book->getPrice() ?></td>
    </tr>
    <tr>
      <th>Description:</th>
      <td><?php echo $book->getDescription() ?></td>
    </tr>
    <tr>
      <th>Author:</th>
      <td><?php echo $book->getAuthor() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('book/edit?id='.$book->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('book/index') ?>">List</a>
