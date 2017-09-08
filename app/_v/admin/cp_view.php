<?php use M5\Library\Auth; ?>
<?php use M5\Library\Session; ?>
<?php use M5\Library\page; ?>

<?php //pa( $data ); ?>

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
</div>


<?php else:?>
 <!-- user access locations	 -->
 <div class="label label-info"> <i class="fa fa-user"></i> مرحبا :
  <?= Session::get("adminName") ?>
</div>
<br>

<?php endif;?> <!-- / access-->


</div>
