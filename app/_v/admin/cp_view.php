<?php use M5\Library\Auth; ?>
<?php use M5\Library\Session; ?>
<?php use M5\Library\page; ?>
<?php use M5\MVC\Shared as C; ?>

<?php //pa( $data ); ?>
<script type="text/javascript" src="<?= assets() ?>/js/Chart.min.js" ></script>

<div id="content">

   <?php //pa($_SESSION)?>
   <?php //die() ?>
   <!-- Authentication -->
   <?php 	$roles =Session::get("roles"); ?>
   <?php if( Auth::valid($roles,[4],'dontshowecho') == "200") : ?>


      <section class="row">
         <content class="col-xs-12 col-md-6">

            <div class="cloud">

               <div class="rain">
                  <div class="hd"> <i class="fa fa-plus"></i>  اختصارات سريعة</div>
               </div>

               <div class="water">

                  <div class="">
                     <div class="pair">
                        <div class="i b_beta">	<i class="fa fa-database"></i> <?= str('blogs')?>   </div>
                        <a href="<?= url('admin/blogs/do/add')?>" class="i"><i class="fa fa-plus"></i> </a>
                     </div>
                  </div>

                  <div class="">
                     <div class="pair">
                        <div class="i b_beta">	<i class="fa fa-database"></i> <?= str('pages')?>   </div>
                        <a href="<?= url('admin/pages/do/add')?>" class="i"><i class="fa fa-plus"></i> </a>
                     </div>
                  </div>

               </div>
            </div>

         </content>

         <content class="col-md-6">

            <div class="cloud">

               <div class="rain">
                  <div class="hd"> <i class="fa fa-globe"></i>الخلفية </div>
               </div>

               <div class="water">

                  <form action="<?=url('admin/theme')?>" method="post" class="">
                     <a name="theme"></a>
                     <?php $bg = $data['bg'] ?>

                     <div class="form-group">
                        <label class="control-label" for="inputError1"> <i class="fa fa-circle small f_base"></i>  خلفية </label>
                        <textarea name="content" class="asURL" cols="30" rows="2"  required><?=$bg ?></textarea>
                     </div>
                     <input type="hidden" name="page" value="<?=Page::url()?>#theme">

                     <input type="submit" value="<?= str('update')?>" name="bgBtnAdd" class="btn btn-primary">
                  </form>
               </div>
            </div>
         </content>

      </section>

      <br>

      <section class="row">
         <content class="col-xs-12 col-md-6">

            <div id="socail_network">
               <legend> <label for=""><i class="fa fa-share-alt"></i> Socail Network Pages </label> </legend>
               <?php //pa($data['sn']) ?>
               <form action="<?=url('admin/cp')?>" method="post">
                  <label class="">Facebook</label>
                  <input type="text" name="fb" value="<?=$data['sn']['fb']?>" class="form-control asUrl">

                  <label class="">Twitter</label>
                  <input type="text" name="tw" value="<?=$data['sn']['tw']?>" class="form-control asUrl">

                  <label class="">Google Plus</label>
                  <input type="text" name="gp" value="<?=$data['sn']['gp']?>" class="form-control asUrl">

                  <label class="">Youtube</label>
                  <input type="text" name="yt" value="<?=$data['sn']['yt']?>" class="form-control asUrl">

                  <label class="">Instagram</label>
                  <input type="text" name="ista" value="<?=$data['sn']['ista']?>" class="form-control asUrl">

                  <input type="submit" name="snBtn" value="<?= string('Update')?>" class="btn btn-primary">
               </form>
            </div>
         </content>

         <content class="col-xs-12 col-md-6">


         </content>

      </section>


      <section>
         <canvas id="chart1" width="800" height="340"></canvas>
         <h3 class="center">الزيارات الشهر الحالي <?=date("m/ Y ")?></h3>

         <?php $mounth_days = cal_days_in_month(CAL_GREGORIAN, date("n"), date("Y")); ?>
         <script type="text/javascript">

            $(document).ready(function($) {

               var chart1= $("#chart1").get(0).getContext("2d");

               var data0 = {
                  labels: [
                  <?php for ($c=$mounth_days; $c>0; $c--): ?> <?php echo '"'.$c.'",' ?> <?php endfor;?>
                  ],

                  datasets: [
                  {
                     label: "All",
                     fillColor: "#199",
                     strokeColor: "#199",
                     pointColor: "rgb(34,140,75)",
                     pointStrokeColor: "#fff",
                     pointHighlightFill: "#ff0",
                     pointHighlightStroke: "rgba(151,187,205,1)",
                     data: [
                     <?php for ($c=$mounth_days; $c>0; $c--): ?> <?php echo '"'.C::_sum2(["day(r_date)" => $c, "month(r_date)" => date("n"), "year(r_date)" => date("Y") ],'audience',0).'",' ?> <?php endfor;?>
                     ]
                  }
                  ]
               };

               var options = {
                  showTooltips: false,
                  onAnimationComplete: function () {

                     var ctx = this.chart.ctx;
                     ctx.font = this.scale.font;
                     ctx.fillStyle = this.scale.textColor
                     ctx.textAlign = "center";
                     ctx.textBaseline = "bottom";

                     this.datasets.forEach(function (dataset) {
                        dataset.bars.forEach(function (bar) {
                           ctx.fillText(bar.value, bar.x, bar.y - 5);
                        });
                     })
                  }
               };

               var myLineChart = new Chart(chart1).Bar(data0,options);

            });
         </script>
      </section>

      <div class="hr"></div>
      <div class="hr"></div>
      <div class="hr"></div>
      <section>

         <canvas id="chart0" width="800" height="340"></canvas>
         <h3 class="center">الزيارات خلال عام <?=date("Y")?></h3>
         <script type="text/javascript">

            $(document).ready(function($) {

               var chart0= $("#chart0").get(0).getContext("2d");

               var data0 = {
                  labels: [
                  <?php for ($c=12; $c>0; $c--): ?> <?php echo '"'.$c.'",' ?> <?php endfor;?>
                  ],

                  datasets: [
                  {
                     label: "All",
                     fillColor: "#199",
                     strokeColor: "#199",
                     pointColor: "rgb(34,140,75)",
                     pointStrokeColor: "#fff",
                     pointHighlightFill: "#ff0",
                     pointHighlightStroke: "rgba(151,187,205,1)",
                     data: [
                     <?php for ($c=12; $c>0; $c--): ?> <?php echo '"'.C::_sum2(["month(r_date)" => $c, "year(r_date)" => date("Y") ],'audience',0).'",' ?> <?php endfor;?>
                     ]
                  }
                  ]
               };

               var options = {
                  showTooltips: false,
                  onAnimationComplete: function () {

                     var ctx = this.chart.ctx;
                     ctx.font = this.scale.font;
                     ctx.fillStyle = this.scale.textColor
                     ctx.textAlign = "center";
                     ctx.textBaseline = "bottom";

                     this.datasets.forEach(function (dataset) {
                        dataset.bars.forEach(function (bar) {
                           ctx.fillText(bar.value, bar.x, bar.y - 5);
                        });
                     })
                  }
               };

               var myLineChart = new Chart(chart0).Bar(data0,options);

            });
         </script>

      </section>


      <section>
         <div id="Traffic">
            <legend> <label for=""> <i class="fa fa-th"></i> Analysis Vistors Traffic </label> </legend>

            <?php if ($this->analysis_traffic): ?>
               <table id=" " class="table table-bordered table-hover b_white _12 _f2 center">
                  <thead>
                     <tr>
                        <th class="b_gray">#</th>
                        <th class="b_gray">Country</th>
                        <th class="b_gray">Traphic</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach ($this->analysis_traffic as $key => $rec): ?>
                        <tr>
                           <td><?= $key+1?></td>
                           <td class="f_beta"><?= !$rec['country'] ? 'unkown' : $rec['country']?></td>
                           <td><div class="label b_beta"><?= $rec['count']?></div></td>
                        </tr>
                     <?php endforeach ?>
                     <tr>
                        <td colspan="2"><?= string('total')?></td>
                        <td> <?= $this->analysis_traffic_all?></td>
                     </tr>
                  </tbody>
               </table>
            <?php endif ?>
         </div>

      </section>





   <?php else:?>
      <!-- user access locations	 -->
      <div class="label label-info"> <i class="fa fa-user"></i> مرحبا :
         <?= Session::get("adminName") ?>
      </div>
      <br>

   <?php endif;?> <!-- / access-->


</div>
