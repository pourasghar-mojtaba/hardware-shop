
							 
						</tbody>
					</table>
				</div>
				<!-- /.box-body -->
				<div class="box-footer clearfix relative">
					<div class="box_paginate_footer">
					 <?php
					  	echo $this->element('Admin/paginate');
					  ?>
					</div>
				</div>
				<div class="clear">
				</div>
			</div>
			<!--body-->


		</div>
	</div>
</section>
<!-- topbar starts -->

<script>
	$(function ()
		{

			$('.box-body input[type="checkbox"]').iCheck(
				{

					checkboxClass: 'icheckbox_flat-blue',
					radioClass: 'iradio_flat-blue'
				});

			$(".checkbox-toggle").click(function ()
				{
					var clicks = $(this).data('clicks');
					if (clicks)
					{
						//Uncheck all checkboxes
						$(".box-body input[type='checkbox']").iCheck("uncheck");
						$(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
					} else
					{
						//Check all checkboxes
						$(".box-body input[type='checkbox']").iCheck("check");
						$(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
					}
					$(this).data("clicks", !clicks);
				});

		});
</script>