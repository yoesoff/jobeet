<h1>Books List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Title</th>
      <th>Price</th>
      <th>Description</th>
      <th>Author</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($books as $book): ?>
    <tr>
      <td><a href="<?php echo url_for('book/show?id='.$book->getId()) ?>"><?php echo $book->getId() ?></a></td>
      <td><?php echo $book->getTitle() ?></td>
      <td><?php echo $book->getPrice() ?></td>
      <td><?php echo $book->getDescription() ?></td>
      <td><?php echo $book->getAuthor() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('book/new') ?>">New</a>
