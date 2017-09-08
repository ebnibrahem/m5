<?php use M5\MVC\Controller as C; ?>
<?php use M5\MVC\Config; ?>

<script type="text/javascript">window.print();</script>

<?php $record = $data['theRecord'] ?>

<?php //pa($record)  ?>

<div id="print" class="b_white">

	<div class="page">


		<table class="" style="margin-bottom: 5px; width: 100%">
			<tr >
				<td width="36%" align="right" > 
					<!-- <img src="<?= Config::get('_PATH').'images/header.jpg' ?>" alt="" width="280px" height="120px">  -->
					<div class=" _f1">
						<strong>
							المملكة العربية السعودية <br >
							وزارة الداخلية <br />
							إمارة منطقة جازان
						</strong>
					</div>
				</td>
				<td width="" align="center" > بسم الله الرحمن الرحيم <br><img src="<?= LOGO ?>" alt="" width="90px" height="90px"> </td>
				<td width="36%" align="left" > <img src="<?=  $record['image']."?".rand(2,50) ?>" alt="" width="90px" height="120px"> </td>
			</tr>			
		</table>

		<table class="table-bordered table b_white ">

			<tbody>			
				<tr>
					<td> <strong class="_f1"> استمارة حصر رقم</strong> </td> 
					<td> <?= $record['block_ID']?> </td>

					<td><strong class="_f1">حصر القبيلة</strong> </td>
					<td> <?= C::typeName('tree', 'ID',$record['tribe'])?> </td>

					<td><strong class="_f1"> رقم دوسيه الحفظ </strong></td> 
					<td> <?= $record['name']?></td>
				</tr>

				<tr>
					<td ><strong class="_f1"> الاسم كاملا</strong></td>
					<td colspan="3"><?= $record['raadbname'] ?></td>

					<td colspan="1"> <strong class="_f1"> الجنسية</strong> </td>
					<td> <?= C::typeName('tree', 'ID',$record['nat'])?> </td>
				</tr>

				<tr>
					<td colspan="1"><strong class="_f1"> الجنس</strong></td>
					<td colspan="3"><span class="xx">  <?= C::typeName('tree', 'ID',$record['gender'])?>  </span> </td>

					<td colspan="1"><strong class="_f1"> الحالة الاجتماعية</strong></td>
					<td><?= C::typeName('tree', 'ID',$record['marred'])?> </td>				
				</tr>

				<tr>
					<td><strong class="_f1"> فصيلة الدم </strong></td>
					<td>				<?= C::typeName('tree', 'ID',$record['blood'])?> </td>

					<td><strong class="_f1"> العلامة الفارقة </strong></td>
					<td><?= $record['unique_signal'] ?></td>

					<td><strong class="_f1"> لون الوجه</strong></td>
					<td><?= $record['face_color'] ?></td>
				</tr>

				<tr class="_item"> 
					<td> <strong class="_f1"> تاريخ الميلاد</strong> </td>
					<td>  <span class="xx"> <?= $record['birth'] ?> </span>  </td>

					<td> <strong class="_f1"> دولة الميلاد</strong> </td>
					<td>  <span class="xx"> <?= $record['birth_country'] ?> </span>  </td>

					<td> <strong class="_f1"> مدينة الميلاد</strong> </td>
					<td>  <span class="xx"> <?= $record['birth_city'] ?> </span>  </td>
				</tr>

				<tr class="_item "> 
					<td > <strong class="_f1"> نوع الهوية</strong>  </td>
					<td colspan="3"> <?= C::typeName('tree', 'ID',$record['ID_type'])?> </td>

					<td> <strong class="_f1"> رقم الهوية</strong>  </td>
					<td><span class="xx"> <?= $record['ID_no'] ?> </span>  </td>
				</tr>

				<tr class="_item "> 
					<td> <strong class="_f1"> تاريخ الاصدار</strong>  </td>
					<td><span class="xx"> <?= $record['ID_issue_date'] ?> </span> </td>

					<td> <strong class="_f1"> مكان الاصدار</strong>  </td>
					<td><span class="_label"> <?= $record['ID_issue_place'] ?> </span> </div> </td>

					<td> <strong class="_f1"> المهنة</strong>  </td>
					<td><span class="_label"> <?= $record['job'] ?> </span>  </td>
				</tr>

				<tr class="_item "> 
					<td> <strong class="_f1"> المستوى التعلمي</strong> </td>
					<td colspan="5"> <?= C::typeName('tree', 'ID',$record['edu_level'])?> </td>
				</tr>

				<tr class="_item "> 
					<td> <strong class="_f1"> المؤسسة التعليمية</strong> </td>
					<td colspan="2">  <span class="_label"> <?= $record['firm_name'] ?> </span>  </td>

					<td> <strong class="_f1"> مقرها</strong>  </td> 
					<td colspan="2"> <span class="_label"> <?= $record['firm_place'] ?> </span> </td>
				</tr>

				<tr class="_item"> 
					<td> <strong class="_f1"> الشهادة الحائز عليها</strong> </td>
					<td > <span class="_label">  <?= C::typeName('tree', 'ID',$record['certify'])?>  </span> </td>

					<td> <strong class="_f1">  التخصص: </strong></td>
					<td><span class="_label"> <?= $record['dept'] ?> </span> </td>

					<td> <strong class="_f1">  تاريخها</strong> </td> 
					<td> <span class="_label"> <?= $record['certify_given_date'] ?> </span> </td>
				</tr>

				<tr class="_item"> 
					<td> <strong class="_f1">  العنوان: </strong>  </td>
					<td colspan="3"> <span class="_label">  <?= C::typeName('tree', 'ID',$record['addr_place'])?> </span> </td>

					<td> <strong class="_f1">  المدينة: </strong>  </td>
					<td> <span class="_label"> <?= $record['city'] ?> </span>  </td>
				</tr>

				<tr class="_item"> 
					<td> <strong class="_f1">  رقم المنزل</strong> </td>
					<td> <span class="_label"> <?= $record['home_no'] ?> </span>  </td>

					<td> <strong class="_f1">  صندوق بريد: </strong> </td>
					<td> <span class="_label"> <?= $record['post_mail'] ?> </span>  </td>

					<td> <strong class="_f1">  الرمز البريدي: </strong>  </td>
					<td> <span class="_label"> <?= $record['zip_mail'] ?> </span>  </td>
				</tr>

				<tr class="_item"> 
					<td> <strong class="_f1">  نوع السكن</strong>  </td>
					<td colspan="5"> <span class="_label"> <?= C::typeName('tree', 'ID',$record['addr_type'])?> </span>  </td>
				</tr>

				<tr>
					<td> <strong class="_f1">  مستوى الدخل الشهري</strong>   </td>
					<td colspan="5"> <span class="_label"> <?= C::typeName('tree', 'ID',$record['revenue'])?> </span>  </td>
				</tr>

				<tr>
					<td> <strong class="_f1">  <?= str('email') ?></strong>   </td>
					<td colspan="3"> <span class="_label"> <?= $record['email'] ?> </span>  </td>

					<td> <strong class="_f1">  <?= str('mobile') ?></strong>   </td>
					<td> <span class="_label"> <?= $record['mobile'] ?> </span>  </td>
				</tr>

				<tr class="_item"> 
					<td> <strong class="_f1"> إسم أحد الأقارب </strong>  </td>
					<td colspan="3"> <span class="_label"> <?= $record['one_family_name']?> </span>  </td>

					<td> <strong class="_f1"> <?= str('mobile') ?> </strong>  </td>
					<td> <span class="_label"> <?= $record['one_family_mobile']?> </span> </td>
				</tr>

				<tr class="_item"> 
					<td colspan="2"> <strong class="_f1"> المستوى التعليمي للأب </strong>  </td>
					<td colspan="4"> <span class="_label">  <?= C::typeName('tree', 'ID',$record['edu_level1'])?> </span>  </td>
				</tr>

				<tr class="_item"> 
					<td colspan="2"> <strong class="_f1"> المستوى التعليمي للأم </strong> 		 </td>
					<td colspan="4"> <span class="xx">  <?= C::typeName('tree', 'ID',$record['edu_level2'])?>  </span>  </td>
				</tr>

				<tr>
					<td> <strong class="_f1"> إسم الأم كاملاً </strong>  </td>
					<td> <span class="xx"> <?= $record['mother_name']?> </span>  </td>

					<td> <strong class="_f1"> جنسيتها </strong>  </td>
					<td> <span class="xx"><?= C::typeName('tree', 'ID',$record['nat2']).'ه'?> </span>  </td>

					<td> <strong class="_f1"> مهنتها </strong>  </td>
					<td> <span class="xx"> <?= $record['mother_job']?> </span>  </td>
				</tr>

				<tr>
					<td> <strong class="_f1"> عدد الاخوة </strong>  </td>
					<td> <span class="xx"> <?= $record['brother_no']?> </span>  </td>

					<td> <strong class="_f1"> عدد الاخوات </strong>  </td>
					<td> <span class="xx"> <?= $record['sister_no']?> </span>  </td>

					<td> <strong class="_f1"> ترتيبك من بين الأبناء </strong>  </td>
					<td> <span class="xx"> <?= $record['your_rank']?> </span>  </td>
				</tr>

			</tbody>

		</table>
		<div class="_14">
			أقر انا الموقع ادناه بان جميع المعلومات المدونة أعلاه صحيحة وأتحمل كافة التبعات القانونية إذا ثبت خلاف ذلك
		</div><br>

		<div class="_14">
			الاسم : ..............................
			التوقيع : ..........................
			التاريخ :  .../......./ .....14هـ
		</div>
	</div>

	<div class="page">
		<br>
		<table class="" style="margin-bottom: 5px; width: 100%">
			<tr >
				<td width="36%" align="right" > 
					<!-- <img src="<?= Config::get('_PATH').'images/header.jpg' ?>" alt="" width="280px" height="120px">  -->
					<div class=" _f1">
						<strong>
							المملكة العربية السعودية <br >
							وزارة الداخلية <br />
							إمارة منطقة جازان
						</strong>
					</div>
				</td>
				<td width="" align="center" > <br><img src="<?= LOGO ?>" alt="" width="90px" height="90px"> </td>
				<td width="36%" align="left" >   </td>
			</tr>			
		</table>


		<legend class="_f0">
			<h3> <i class="fa fa-circle small"></i> أفراد الاسرة : </h3>
		</legend>
		<?php $family = $record['family']['data']  ?>
		<a name="family"></a>
		<?php if ($family): ?>
			<?php //pa($family) ?>

			<table class="table table-bordered table-hover b_white center">
				<thead>
					<tr>
						<th class="center b_gray" >#</th>

						<th class="center b_gray" > الإسم </th>
						<th class="center b_gray" > صلة القرابة </th>
						<th class="center b_gray" > تاريخ الميلاد </th>
						<th class="center b_gray" > المستوى التعليمي </th>
					</tr>
				</thead>
				<?php  $records = $family  ?>
				<tbody>
					<?php foreach ($records as $key => $rcrd): ?>
						<tr>
							<td>
								<?php if($_GET['page']) :?>
									<?= ( ($_GET['page'] - 1)*$meta['offset'])+$key+1 ?>
								<?php else:?>
									<?= ($key+1) ?>
								<?php endif;?>
							</td>

							<td> <a class="f_base" href="<?= url("admin/records2/".$rcrd["ID"])?>"><?= $rcrd["name"]?></a></td>
							<td > <?= C::typeName('tree', 'ID',$rcrd['relevance'])?> </td>
							<td > <?= $rcrd['birth'] ?> </td>
							<td > <?= C::typeName('tree', 'ID',$rcrd['edu_level'])?> </td>


						</tr>
					<?php endforeach;?>
				</tbody>
			</table>

			<div class="_14">
				ترفق صور من : ( شهادات ميلاد التابعين ، المؤهلات العلمية ، جوازات السفر ، هوية ، بطاقة تنقل ، صك طلاق بالنسبة للمطلقات ، صك حصر إرث بالنسبة للمتوفي )
				المقر بجميع ماذكر : 
				<br /><br />
				الإسم : .................................... 
				التوقيع : ............................ 
				التاريخ : ..... / ..... / ..... 14 هـ
			</div>
			<br>

			<table class="table table-bordered b_white alignR">
				<thead>
					<tr> <td colspan="2"> <strong>	خاص للاستعمال الرسمي : </strong> </td></tr>

					<tr>
						<td td colspan="2">
							<div class="form-group">
								<input type="checkbox" name="" id="">
								المعلومات المدونة أعلاه مطابقة 
							</div>
						</td>
					</tr>
					<tr>
						<td td colspan="2">
							<div class="form-group">
								<input type="checkbox" name="" id="">
								تم أخذ الخصائص الحيوية للمعني والتابعين ( بصمة الأصبع / بصمة الوجه )
							</div>
						</td>
					</tr>


					<tr>
						<td>
							<div class="form-group">
								<input type="checkbox" name="" id="">
								ليس عليه سوابق 
							</div>
						</td>
						<td>
							<div class="form-group">
								<input type="checkbox" name="" id="">
								عليه سوابق برقم (........................)
							</div>
						</td>
					</tr>

					<tr>
						<td colspan="2">
							<input type="checkbox" name="" id="">
							لديه هوية أخرى : نوعها (.................... ) رقمها (............) مصدرها : (............) تاريخها : ....../...../   
							<br>
							<br>
						</td>
					</tr>

					<tr>
						<td><b>تصديق المختص بالأحوال المدنية مع الختم الرسمي	</b></td>
						<td><b>تصديق المختص بالجوازات مع الختم الرسمي</b></td>
					</tr>
					<tr>
						<td> الاسم :.............................................. </td>
						<td> الاسم :.............................................. </td>
					</tr>
					<tr>
						<td> التوقيع :............................................. </td>
						<td> التوقيع :............................................. </td>
					</tr>
					<tr>
						<td> التاريخ :....................../14هـ </td>
						<td> التاريخ :....................../14هـ </td>
					</tr>
				</thead>
			</table>

		<?php endif ?>
	</div>

</div>

<style type="text/css">
	#bread, #anchor, header{
		display: none;
	}
	.aside_open{
		opacity: 0.2;
	}
	.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
		padding: 3px;
	}


	body {
		margin: 0;
		padding: 0;
		background-color: #FAFAFA;
		font: 12pt "Tahoma";
	}
	* {
		box-sizing: border-box;
		-moz-box-sizing: border-box;
	}
	.page {
		width: 21cm;
		min-height: 29.7cm;
		padding: 2cm 1cm;
		margin: 1cm auto;
		border: 1px #D3D3D3 solid;
		border-radius: 5px;
		background: white;
		box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
	}
	.subpage {
		padding: 1cm;
		border: 5px red solid;
		height: 256mm;
		outline: 2cm #FFEAEA solid;
	}

	@page {
		size: A4;
		margin: 0;
	}
	@media print {
		.page {
			padding: 2cm 1cm;
			margin: 0;
			border: initial;
			border-radius: initial;
			width: initial;
			min-height: initial;
			box-shadow: initial;
			background: initial;
			page-break-after: always;
		}

		html, body {
			width: 210mm;
			height: 297mm;
		}
	}

</style>