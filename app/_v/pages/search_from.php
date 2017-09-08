<div id="search_from">
	
	<form action="<?= url('ads') ?>">

		<div class="row">
			<div class="col-sm-8">
				<div class="form-group">
					<input type="search" name="q" placeholder="<?= str('search')?>" value="<?= M5\Library\Clean::sqlInjection($_GET['q'])?>">
				</div>

			</div>

			<div class="col-sm-4">
				<input type="submit" value="<?= str('search')?>" class="auto_margin b_base">
				
			</div>
		</div>


	</form>

</div>