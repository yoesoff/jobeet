<ul>  
<?php foreach($books as $book):?>  
  <li>
    +<a href="<?php echo url_for('book/show?id='.$book->getId())?>"><?php echo $book->getTitle()?></a>
    -<a href="<?php echo url_for('book/view?author='.  
        $book->getAuthor().'&title='.  
        $book->getTitle())?>">  
      <?php echo $book->getTitle()?>  
    </a>  
  </li>  
<?php endforeach?>  
</ul>