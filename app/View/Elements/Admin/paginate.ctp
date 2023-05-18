<ul class="pagination">
<?php echo $this->Paginator->prev(__('prev'), array('tag'=>'li'), null, array('disabledTag'=>'a','tag'=>'li','class'=> 'paginate_button previous disabled'));?>
<?php echo $this->Paginator->numbers(array('tag'=>'li','separator' =>'','currentClass'=>'paginate_button active','currentTag'  =>'a'));?>
<?php echo $this->Paginator->next(__('next'), array('tag'=>'li'), null, array('disabledTag'=>'a','tag'=>'li','class'=> 'paginate_button next disabled'));?>
</ul>