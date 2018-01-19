<?php
/**
* Шаблон для формы регистрации
*/
?>

<div class="col-lg-4 col-lg-offset-4">
	<h1>Форма регистрации</h1>
	<p>Введите пожалуйста информацию о себе</p>
	<?php $fattr = array('class' => 'form-signin');
	echo form_open(base_url().'index.php/user/register', $fattr); ?>
	<div class="form-group">
		<?php echo form_input(array(
			'name'=>'firstname',
			'id'=>'firstname',
			'placeholder'=>'Имя',
			'class'=>'form-control',
			'value'=>set_value('firstname')
			)); ?>
		<?php echo form_error('firstname');?>
	</div>
	<div class="form-group">
		<?php echo form_input(array(
			'name'=>'lastname',
			'id'=>'lastname',
			'placeholder'=>'Фамилия',
			'class'=>'form-control',
			'value'=>set_value('lastname')
			)); ?>
		<?php echo form_error('lastname');?>
	</div>
	<div class="form-group">
		<?php echo form_input(array(
			'name'=>'email',
			'id'=>'email',
			'placeholder'=>'E-Mail',
			'class'=>'form-control',
			'value'=>set_value('email')
			)); ?>
		<?php echo form_error('email');?>
	</div>
	<div class="form-group">
		<?php echo form_password(array(
			'name'=>'password',
			'id'=>'password',
			'placeholder'=>'Пароль',
			'class'=>'form-control',
			'value'=>set_value('password')
		)); ?>
		<?php echo form_error('password') ?>
	</div>
	<div class="form-group">
		<?php echo form_password(array(
			'name'=>'passconf',
			'id'=>'passconf',
			'placeholder'=>'Подтвердите пароль',
			'class'=>'form-control',
			'value'=>set_value('passconf')
		)); ?>
		<?php echo form_error('passconf') ?>
	</div>
	
	<div class="form-group">
		<?php echo form_submit(array(
			'value'=>'Регистрация',
			'class'=>'btn btn-lg btn-primary btn-block'
			)); ?>
		<?php echo form_close();?>
	</div>
</div>