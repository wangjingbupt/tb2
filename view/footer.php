
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
		<div >
		<div class='well1' style='float:right;padding:0 10px;'>
		<p><small>Bluid on <a class="text-info" href='http://php.net/' target='_blank'>PHP</a> \ <a class="text-info" href='http://nginx.org/' target='_blank' >Nginx</a> \ <a class="text-info" href='http://twitter.github.io/bootstrap/index.html' target='_blank'>Bootstrap</a> \ <a class="text-info" href='http://www.mongodb.org/' target='_blank'>MongoDB</a></small></p>
		</div>
		</div>
		<?php if(isset($data['script']))echo $data['script']?>
		<?php if($_GET['addCart'] == 'succ') 
		{
			?>
			<script>
			$(window).ready(function(){
				$('#cart').popover('toggle');
			//sleep(3000);
				setTimeout(function(){
					$('#cart').popover('destroy');}, 3000);
				}
			);
			</script>
			<?php } ?>

  </body>
</html>
