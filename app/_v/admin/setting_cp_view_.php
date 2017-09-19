<?php use M5\Library\Page; ?>

<div id="content">
	<?php //pa( $this ); ?>
	<?php //pa( $data["records"] ); ?>

	<section class="row" data-doc="1">
		<content class="col-md-6 col-xs-12 ">

			<!-- products_gross_sataus -->
			<form action="<?=url($this->formAction)?>" method="post" class="b90 auto_margin form-inline">
				<h5> <label for=""><i class="fa fa-circle vsmall"></i> اخفاء الكمية المطلوبة ؟ </label> </h5>
				<a name="products_gross_sataus"></a>
				<?php $products_gross_sataus = $data['products_gross_sataus'] ?>

				<div class="form-group b60">
					<select name="products_gross_sataus" class="form-control b100">
						<option value="show" >عرض</option>
						<option value="hide" <?= $products_gross_sataus == "hide" ? 'selected' : ''?> >اخفاء</option>
					</select>
				</div>

				<div class="form-group">
					<input type="submit" value="<?= str('customize')?>" name="products_gross_satausBtnAdd" class="btn btn-primary auto_margin">
					<input type="hidden" name="page" value="<?=Page::url()?>#products_gross_sataus">
				</div>
			</form>

		</content>

		<content class="col-md-6 col-xs-12 ">

			<form action="<?=url('admin/theme')?>" method="post" class="form-inline">
				<a name="themeColor"></a>
				<?php $main_color = $data['main_color'] ?>

				<h5 class="control-label" for="inputError1">
					<i class="fa fa-circle small f_base"></i>  اللون الرئيسي
					<div class="main_color ib b10" style="height: 30px"></div>
				</h5>
				<br>

				<div class="form-group">
					<input type="text" id="main_color" name="content" class="asURL" value="<?= $main_color ?>">
				</div>

				<input type="submit" value="<?= str('customize')?>" name="main_colorBtnAdd" class="btn btn-primary auto_margin ">
				<input type="hidden" name="page" value="<?=Page::url()?>#themeColor">

				<script type="text/javascript">$(document).ready(function($) {
					$(".main_color").css({'background-color': $("#main_color").val()});
					$("#main_color").bind("keyup foucs mousemove",function(event) {
						$(".main_color").css({'background-color': $(this).val()});
					});
				});</script>
			</form>

			<form action="<?=url($this->formAction)?>" method="post" class="form-inline">
				<a name="curerncysymbol"></a>
				<?php $curerncysymbol = $data['curerncysymbol'] ?>

				<div class="form-group">
					<h5 class="control-label" for="inputError1">
						<i class="fa fa-circle small f_base"></i>  مسمى العملة:
					</h5>
				</div>
				<br>

				<div class="form-group">
					<input type="text" name="curerncysymbol" value="<?= $curerncysymbol ?>">
				</div>

				<input type="submit" value="<?= str('customize')?>" name="curerncysymbolBtnAdd" class="btn btn-primary auto_margin">
				<input type="hidden" name="page" value="<?=Page::url()?>#curerncysymbol">

			</form>


			<form action="<?=url('admin/theme')?>" method="post" class="b90 auto_margin hide">
				<a name="theme"></a>

				<legend> <label for=""><i class="fa fa-paint-brush"></i> <?=str("theme")?> </label> </legend>

				<?php $bg = $data['bg'] ?>

				<div class="form-group">
					<label class="control-label" for="inputError1"> <i class="fa fa-circle small f_base"></i>  خلفية </label>
					<textarea name="content" class="asURL" cols="30" rows="2"  required><?=$bg ?></textarea>
				</div>
				<input type="hidden" name="page" value="<?=Page::url()?>#theme">

				<input type="submit" value="<?= str('update')?>" name="bgBtnAdd" class="btn btn-primary">
			</form>
		</content>
	</section>



	<br>
	<section class="row" data-doc="@">
		<content class="col-md-6 col-xs-12 ">
			<!-- naming -->
			<legend>تسميات</legend>

			<form action="<?=url($this->formAction)?>" method="post" class="b90 auto_margin form-inline">
				<h5> <label for=""><i class="fa fa-circle vsmall"></i> وكيل اعتيادي </label> </h5>
				<?php $naming_client_type1 = $data['naming']['client_type1'] ?>

				<div class="form-group">
					<input type="text" id="naming_client_type1" name="content" class="" value="<?= $naming_client_type1 ?>">
				</div>

				<div class="form-group">
					<input type="submit" value="<?= str('customize')?>" name="namingBtnAdd" class="btn btn-primary auto_margin">
					<input type="hidden" name="page" value="<?=Page::url()?>#naming_client_type1">
					<input type="hidden" name="key" value="naming_client_type1">
				</div>
			</form>
			<form action="<?=url($this->formAction)?>" method="post" class="b90 auto_margin form-inline">
				<h5> <label for=""><i class="fa fa-circle vsmall"></i> وكيل اقليمي </label> </h5>
				<?php $naming_client_type2 = $data['naming']['client_type2'] ?>

				<div class="form-group">
					<input type="text" id="naming_client_type2" name="content" class="" value="<?= $naming_client_type2 ?>">
				</div>

				<div class="form-group">
					<input type="submit" value="<?= str('customize')?>" name="namingBtnAdd" class="btn btn-primary auto_margin">
					<input type="hidden" name="page" value="<?=Page::url()?>#naming_client_type2">
					<input type="hidden" name="key" value="naming_client_type2">
				</div>
			</form>


			<form action="<?=url($this->formAction)?>" method="post" class="b90 auto_margin form-inline">
				<h5> <label for=""><i class="fa fa-circle vsmall"></i> وكيل خاص </label> </h5>
				<a name="naming"></a>
				<?php $naming_client_type3 = $data['naming']['client_type3'] ?>

				<div class="form-group">
					<input type="text" id="naming_client_type3" name="content" class="" value="<?= $naming_client_type3 ?>">
				</div>

				<div class="form-group">
					<input type="submit" value="<?= str('customize')?>" name="namingBtnAdd" class="btn btn-primary auto_margin">
					<input type="hidden" name="page" value="<?=Page::url()?>#naming_client_type3">
					<input type="hidden" name="key" value="naming_client_type3">
				</div>
			</form>
		</content>

		<content class="col-md-6 col-xs-12 ">
			<!-- grosses_style -->
			<legend> الادخال المخزوني للكميات والاسعار
			</legend>

			<form action="<?=url($this->formAction)?>" method="post" class="b90 auto_margin form-inline">
				<h5> <label for=""><i class="fa fa-circle vsmall"></i>طريقة ادخال المنتجات:</label> </h5>
				<a name="grosses_style"></a>
				<?php $grosses_style = $data['grosses_style'] ?>

				<div class="form-group b60">
					<select name="grosses_style" class="form-control b100">
						<option value="default" >الافتراضي</option>
						<option value="invoice" <?= $grosses_style == "invoice" ? 'selected' : ''?> > فاتورة شراء </option>
					</select>
				</div>
				<div class="form-group">
					<input type="submit" value="<?= str('customize')?>" name="grosses_styleBtnAdd" class="btn btn-primary auto_margin">
					<input type="hidden" name="page" value="<?=Page::url()?>#grosses_style">
				</div>
			</form>

			<hr>

			<!-- order_style -->
			<legend> طلب المنتجات لدي الوكلاء
			</legend>

			<form action="<?=url($this->formAction)?>" method="post" class="b90 auto_margin form-inline">
				<h5> <label for=""><i class="fa fa-circle vsmall"></i> <u class="f_blue"> طريقة بيع المنتجات</u> :</label> </h5>
				<a name="order_style"></a>
				<?php $order_style = $data['order_style'] ?>

				<div class="form-group b60">
					<select name="order_style" class="form-control b100">
						<option value="default" >الافتراضي</option>
						<option value="invoice" <?= $order_style == "invoice" ? 'selected' : ''?> > فاتورة بيع </option>
					</select>
				</div>
				<div class="form-group">
					<input type="submit" value="<?= str('customize')?>" name="order_styleBtnAdd" class="btn btn-primary auto_margin">
					<input type="hidden" name="page" value="<?=Page::url()?>#order_style">
				</div>
			</form>

			<hr>
			<!-- products_view_style -->
			<form action="<?=url($this->formAction)?>" method="post" class="b90 auto_margin form-inline">
				<h5> <label for=""><i class="fa fa-circle vsmall"></i>طريقة عرض المنتجات: في حالة  <u class="f_blue"> طريقة بيع المنتجات</u>  = افتراضي</label> </h5>
				<a name="products_view_style"></a>
				<?php $products_view_style = $data['products_view_style'] ?>

				<div class="form-group b60">
					<select name="products_view_style" class="form-control b100">
						<option value="table" >جدول</option>
						<option value="block" <?= $products_view_style == "block" ? 'selected' : ''?> >شبكة</option>
					</select>
				</div>
				<div class="form-group">
					<input type="submit" value="<?= str('customize')?>" name="products_view_styleBtnAdd" class="btn btn-primary auto_margin">
					<input type="hidden" name="page" value="<?=Page::url()?>#products_view_style">
				</div>
			</form>

		</content>
	</section>



</div>