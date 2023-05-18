		      </div>
			  <?php
			    $showSave = TRUE;
				if(isset($items['save']) && $items['save']== FALSE){
					$showSave = FALSE;
				}
				if ($showSave){				
			  ?>
              <div class="box-footer">
                <button class="btn btn-primary" type="submit"><?php echo __('save'); ?></button>
              </div>
              <?php } ?>
          </div>
		</div>
	</div>
</section>	